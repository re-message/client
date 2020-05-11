<?php

namespace RM\Component\Client\Security\Authenticator;

use RM\Component\Client\Repository\RepositoryTrait;
use RM\Component\Client\Security\Storage\ActorStorageInterface;
use RM\Component\Client\Security\Storage\TokenStorageInterface;
use RM\Standard\Message\MessageInterface;
use RuntimeException;

/**
 * Class AbstractAuthenticator
 *
 * @package RM\Component\Client\Security\Authenticator
 * @author  h1karo <h1karo@outlook.com>
 */
abstract class AbstractAuthenticator implements AuthenticatorInterface
{
    use RepositoryTrait;

    private ActorStorageInterface $actorStorage;

    /**
     * @inheritDoc
     */
    public function authorize(): object
    {
        $message = $this->createMessage();
        $response = $this->send($message);

        $content = $response->getContent();
        $token = $content['token'];
        $objectData = $content[$this->getObjectKey()];

        $entity = $this->hydrate($objectData);
        if (!is_a($entity, $this->getEntity())) {
            throw new RuntimeException(sprintf('Hydrated entity is not %s.', $this->getEntity()));
        }

        $this->saveToken($token, $this->transport->getTokenStorage());
        $this->saveEntity($entity, $this->actorStorage);
        return $entity;
    }

    /**
     * Saves received entity into storage.
     *
     * @param object                $entity
     * @param ActorStorageInterface $actorStorage
     */
    abstract protected function saveEntity(object $entity, ActorStorageInterface $actorStorage): void;

    /**
     * Saves received access token into storage.
     *
     * @param string                $token
     * @param TokenStorageInterface $tokenStorage
     */
    protected function saveToken(string $token, TokenStorageInterface $tokenStorage): void
    {
        $tokenStorage->set(static::getTokenType(), $token);
    }

    /**
     * @inheritDoc
     */
    public function setActorStorage(ActorStorageInterface $actorStorage): self
    {
        $this->actorStorage = $actorStorage;

        return $this;
    }

    /**
     * Returns generated message to for authorization.
     *
     * @return MessageInterface
     */
    abstract protected function createMessage(): MessageInterface;

    /**
     * Returns key of object location in the response content.
     *
     * @return string
     */
    abstract protected function getObjectKey(): string;
}
