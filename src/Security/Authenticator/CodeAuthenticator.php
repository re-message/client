<?php

namespace RM\Component\Client\Security\Authenticator;

use RM\Component\Client\Entity\User;
use RM\Component\Client\Hydrator\HydratorInterface;
use RM\Component\Client\Model\CodeMethod;
use RM\Component\Client\Model\Preferences;
use RM\Component\Client\Repository\RepositoryTrait;
use RM\Component\Client\Security\Authenticator\Factory\AuthenticatorFactoryInterface;
use RM\Component\Client\Security\Storage\AuthorizationStorageInterface;
use RM\Component\Client\Transport\TransportInterface;
use RM\Standard\Message\Action;
use RM\Standard\Message\MessageInterface;

/**
 * Class CodeAuthenticator
 *
 * @package RM\Component\Client\Security\Authenticator
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
class CodeAuthenticator implements RedirectAuthenticatorInterface
{
    use RepositoryTrait;

    private AuthorizationStorageInterface $storage;
    private AuthenticatorFactoryInterface $authenticatorFactory;

    private string $phone;
    private Preferences $preferences;

    public function __construct(
        TransportInterface $transport,
        HydratorInterface $hydrator,
        AuthorizationStorageInterface $storage
    ) {
        $this->transport = $transport;
        $this->hydrator = $hydrator;
        $this->storage = $storage;
        $this->preferences = new Preferences();
    }

    /**
     * @inheritDoc
     */
    public function setFactory(AuthenticatorFactoryInterface $authenticatorFactory): RedirectAuthenticatorInterface
    {
        $this->authenticatorFactory = $authenticatorFactory;

        return $this;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    public function getPreferences(): Preferences
    {
        return $this->preferences;
    }

    public function setPreferences(Preferences $preferences): self
    {
        $this->preferences = $preferences;
        return $this;
    }

    public function authenticate(): AuthenticatorInterface
    {
        $message = $this->createCodeMessage();
        $response = $this->send($message);
        $content = $response->getContent();

        $request = $content['request'];
        $method = CodeMethod::get($content['method']);
        $this->preferences->setMethod($method);

        /** @var SignInAuthenticator $authenticator */
        $authenticator = $this->authenticatorFactory->build(SignInAuthenticator::class);
        return $authenticator
            ->setPhone($this->phone)
            ->setRequest($request)
            ->store();
    }

    protected function createCodeMessage(): MessageInterface
    {
        return new Action(
            'auth.sendCode',
            [
                'phone' => $this->phone,
                'preferences' => $this->preferences->toArray()
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public static function getTokenType(): string
    {
        return 'code';
    }

    /**
     * @inheritDoc
     */
    public function getEntity(): string
    {
        return User::class;
    }
}
