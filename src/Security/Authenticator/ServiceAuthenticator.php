<?php

namespace RM\Component\Client\Security\Authenticator;

use RM\Component\Client\Entity\Application;
use RM\Standard\Message\Action;
use RM\Standard\Message\MessageInterface;

/**
 * Class ServiceAuthenticator
 *
 * @package RM\Component\Client\Security\Authenticator
 * @author  h1karo <h1karo@outlook.com>
 */
class ServiceAuthenticator extends AbstractAuthenticator
{
    public const TOKEN_TYPE = 'service';

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
                'applicationId' => $this->id,
                'secret' => $this->secret
            ]
        );
    }

    /**
     * @inheritDoc
     */
    protected function getObjectKey(): string
    {
        return 'application';
    }

    /**
     * @inheritDoc
     */
    public function getEntity(): string
    {
        return Application::class;
    }
}