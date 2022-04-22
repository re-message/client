<?php
/*
 * This file is a part of Re Message Client.
 * This package is a part of Re Message.
 *
 * @link      https://github.com/re-message/client
 * @link      https://dev.remessage.ru/packages/client
 * @copyright Copyright (c) 2018-2022 Re Message
 * @author    Oleg Kozlov <h1karo@remessage.ru>
 * @license   Apache License 2.0
 * @license   https://legal.remessage.ru/licenses/client
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
 * @see https://dev.remessage.ru/security/user
 *
 * @author Oleg Kozlov <h1karo@remessage.ru>
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
