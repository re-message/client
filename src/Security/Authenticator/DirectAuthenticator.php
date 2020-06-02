<?php

namespace RM\Component\Client\Security\Authenticator;

use RM\Component\Client\Hydrator\HydratorInterface;
use RM\Component\Client\Repository\RepositoryTrait;
use RM\Component\Client\Security\Credentials\AuthorizationInterface;
use RM\Component\Client\Security\Storage\AuthorizationStorageInterface;
use RM\Component\Client\Transport\TransportInterface;
use RM\Standard\Message\MessageInterface;
use RuntimeException;

/**
 * Class DirectAuthenticator
 *
 * @package RM\Component\Client\Security\Authenticator
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
abstract class DirectAuthenticator implements StorableAuthenticatorInterface
{
    use RepositoryTrait;

    protected AuthorizationStorageInterface $storage;

    public function __construct(TransportInterface $transport, HydratorInterface $hydrator)
    {
        $this->transport = $transport;
        $this->hydrator = $hydrator;
    }

    public function setStorage(AuthorizationStorageInterface $storage): self
    {
        $this->storage = $storage;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function authenticate(): object
    {
        $message = $this->createMessage();
        $response = $this->send($message);

        $content = $response->getContent();
        $credentials = $content[$this->getCredentialsKey()];
        $objectData = $content[$this->getObjectKey()];

        $entity = $this->hydrate($objectData);
        if (!is_a($entity, $this->getEntity())) {
            throw new RuntimeException(sprintf('Hydrated entity is not %s.', $this->getEntity()));
        }

        $authorization = $this->createAuthorization($credentials);
        $this->storage->set(static::getTokenType(), $authorization);

        return $entity;
    }

    /**
     * Creates authorization object to store in storage.
     *
     * @param string $credentials
     *
     * @return AuthorizationInterface
     */
    abstract protected function createAuthorization(string $credentials): AuthorizationInterface;

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

    /**
     * Name of the parameter containing the credentials.
     *
     * @return string
     */
    protected function getCredentialsKey(): string
    {
        return 'token';
    }
}
