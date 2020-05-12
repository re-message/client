<?php

namespace RM\Component\Client\Security\Authenticator;

use InvalidArgumentException;
use RM\Component\Client\Entity\Application;
use RM\Component\Client\Security\Storage\ActorStorageInterface;
use RM\Standard\Message\Action;
use RM\Standard\Message\MessageInterface;

/**
 * Class ServiceAuthenticator
 *
 * @package RM\Component\Client\Security\Authenticator
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
class ServiceAuthenticator extends AbstractAuthenticator
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

    protected function saveEntity(object $entity, ActorStorageInterface $actorStorage): void
    {
        if (!$entity instanceof Application) {
            $message = sprintf('Expects %s, got %s.', Application::class, get_class($entity));
            throw new InvalidArgumentException($message);
        }

        $actorStorage->setApplication($entity);
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

    /**
     * @inheritDoc
     */
    public static function getTokenType(): string
    {
        return 'service';
    }
}
