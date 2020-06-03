<?php

namespace RM\Component\Client\Security\Authenticator;

use RM\Component\Client\Entity\Application;
use RM\Component\Client\Security\Credentials\AuthorizationInterface;
use RM\Component\Client\Security\Credentials\Token;
use RM\Standard\Message\Action;
use RM\Standard\Message\MessageInterface;

/**
 * Class ServiceAuthenticator provides ability to authenticate the application.
 *
 * @package RM\Component\Client\Security\Authenticator
 * @author  Oleg Kozlov <h1karo@outlook.com>
 * @link    https://dev.relmsg.ru/security/service
 */
class ServiceAuthenticator extends DirectAuthenticator
{
    private string $id;
    private string $secret;

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function setSecret(string $secret): self
    {
        $this->secret = $secret;

        return $this;
    }

    /**
     * @inheritDoc
     */
    protected function createMessage(): MessageInterface
    {
        return new Action(
            'auth.authorize',
            [
                'application' => $this->id,
                'secret' => $this->secret
            ]
        );
    }

    /**
     * @inheritDoc
     */
    protected function createAuthorization(string $credentials): AuthorizationInterface
    {
        return new Token($credentials);
    }

    /**
     * @inheritDoc
     */
    public function getEntity(): string
    {
        return Application::class;
    }

    /**
     * @inheritDoc
     */
    public static function getTokenType(): string
    {
        return 'service';
    }

    /**
     * @inheritDoc
     */
    protected function getObjectKey(): string
    {
        return 'application';
    }
}
