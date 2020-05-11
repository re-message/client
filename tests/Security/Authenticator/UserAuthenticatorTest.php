<?php

namespace RM\Component\Client\Tests\Security\Authenticator;

use PHPUnit\Framework\TestCase;
use RM\Component\Client\Entity\User;
use RM\Component\Client\Hydrator\EntityHydrator;
use RM\Component\Client\Model\CodeMethod;
use RM\Component\Client\Security\Authenticator\UserAuthenticator;
use RM\Component\Client\Security\Storage\ActorStorage;
use RM\Component\Client\Security\Storage\TokenStorage;
use RM\Component\Client\Transport\TransportInterface;
use RM\Standard\Message\Response;

class UserAuthenticatorTest extends TestCase
{
    public function testConstructor(): void
    {
        $transport = $this->createMock(TransportInterface::class);
        $authenticator = new UserAuthenticator($transport, new EntityHydrator());
        $this->assertEquals(User::class, $authenticator->getEntity());
    }

    /**
     * @dataProvider provideSendCodeData
     *
     * @param string $request
     * @param string $phone
     */
    public function testSendCode(string $request, string $phone): void
    {
        $transport = $this->createMock(TransportInterface::class);
        $transport
            ->expects($this->once())
            ->method('send')
            ->willReturn(new Response(['request' => $request, 'method' => CodeMethod::SMS]));

        $authenticator = new UserAuthenticator($transport, new EntityHydrator());
        $authenticator->setPhone($phone)->sendCode();
        $this->assertEquals($request, $authenticator->getRequest());
    }

    public function provideSendCodeData(): iterable
    {
        yield ['request' => '0987654', 'phone' => '+71234567456'];
    }

    /**
     * @dataProvider provideAuthorizeResponse
     *
     * @param string $token
     * @param array  $user
     */
    public function testAuthorize(string $request, string $phone, string $token, array $user): void
    {
        $tokenStorage = new TokenStorage();

        $transport = $this->createMock(TransportInterface::class);
        $transport
            ->expects($this->once())
            ->method('send')
            ->willReturn(new Response(['token' => $token, 'user' => $user]));
        $transport
            ->expects($this->once())
            ->method('getTokenStorage')
            ->willReturn($tokenStorage);
        $authenticator = new UserAuthenticator($transport, new EntityHydrator());

        $actorStorage = new ActorStorage();
        $authenticator->setActorStorage($actorStorage)->setCode('some-code');
        $authenticator->setPhone($phone)->setRequest($request);

        $user = $authenticator->authorize();
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($token, $tokenStorage->get($authenticator::getTokenType()));
        $this->assertEquals($actorStorage->getUser(), $user);
    }

    public function provideAuthorizeResponse(): iterable
    {
        yield [
            'phone' => '+71234567456',
            'request' => '0987654',
            'token' => 'some-token',
            'user' => [
                'id' => 'some-user-id',
                'firstName' => 'bruh',
                'birthday' => 1589189281
            ]
        ];
    }
}
