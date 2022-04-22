<?php
/*
 * This file is a part of Relations Messenger Client.
 * This package is a part of Relations Messenger.
 *
 * @link      https://github.com/relmsg/client
 * @link      https://dev.relmsg.ru/packages/client
 * @copyright Copyright (c) 2018-2022 Relations Messenger
 * @author    Oleg Kozlov <h1karo@relmsg.ru>
 * @license   https://legal.relmsg.ru/licenses/client
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RM\Component\Client\Security\Authenticator;

use RM\Component\Client\Entity\User;
use RM\Component\Client\Hydrator\HydratorInterface;
use RM\Component\Client\Model\CodeMethod;
use RM\Component\Client\Model\Preferences;
use RM\Component\Client\Repository\RepositoryTrait;
use RM\Component\Client\Security\Authenticator\Factory\AuthenticatorFactoryInterface;
use RM\Component\Client\Transport\TransportInterface;
use RM\Standard\Message\Action;
use RM\Standard\Message\MessageInterface;

/**
 * Class CodeAuthenticator provides ability to start the user authorization process.
 *
 * @author Oleg Kozlov <h1karo@relmsg.ru>
 *
 * @see   https://dev.relmsg.ru/security/user
 */
class CodeAuthenticator implements RedirectAuthenticatorInterface
{
    use RepositoryTrait;

    private AuthenticatorFactoryInterface $authenticatorFactory;

    private string $phone;
    private Preferences $preferences;

    public function __construct(TransportInterface $transport, HydratorInterface $hydrator)
    {
        $this->transport = $transport;
        $this->hydrator = $hydrator;
        $this->preferences = new Preferences();
    }

    /**
     * @inheritDoc
     */
    public function setFactory(AuthenticatorFactoryInterface $authenticatorFactory): static
    {
        $this->authenticatorFactory = $authenticatorFactory;

        return $this;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPreferences(): Preferences
    {
        return $this->preferences;
    }

    public function setPreferences(Preferences $preferences): static
    {
        $this->preferences = $preferences;

        return $this;
    }

    public function authenticate(): AuthenticatorInterface
    {
        $message = $this->createMessage();
        $response = $this->send($message);
        $content = $response->getContent();

        $request = $content['request'];
        $method = CodeMethod::from($content['method']);
        $this->preferences->setMethod($method);

        /** @var SignInAuthenticator $authenticator */
        $authenticator = $this->authenticatorFactory->build(SignInAuthenticator::class);

        return $authenticator
            ->setPhone($this->phone)
            ->setRequest($request)
            ->store()
        ;
    }

    protected function createMessage(): MessageInterface
    {
        return new Action(
            'auth.sendCode',
            [
                'phone' => $this->phone,
                'preferences' => $this->preferences->toArray(),
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
