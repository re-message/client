<?php

namespace RM\Component\Client;

use RM\Component\Client\Entity\Application;
use RM\Component\Client\Entity\User;
use RM\Component\Client\Repository\RepositoryInterface;
use RM\Component\Client\Repository\RepositoryRegistryInterface;
use RM\Component\Client\Security\Authenticator\AuthenticatorFactoryInterface;
use RM\Component\Client\Security\Authenticator\AuthenticatorInterface;
use RM\Component\Client\Security\Storage\ActorStorageInterface;
use RM\Component\Client\Security\Storage\TokenStorageInterface;
use RM\Component\Client\Transport\TransportInterface;
use RM\Standard\Message\MessageInterface;

/**
 * Class Client
 *
 * @package RM\Component\Client
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
class Client implements ClientInterface
{
    private TransportInterface $transport;
    private RepositoryRegistryInterface $registry;
    private AuthenticatorFactoryInterface $authenticatorFactory;
    private ActorStorageInterface $actorStorage;

    public function __construct(
        TransportInterface $transport,
        RepositoryRegistryInterface $registry,
        AuthenticatorFactoryInterface $authenticatorFactory,
        ActorStorageInterface $actorStorage
    ) {
        $this->transport = $transport;
        $this->registry = $registry;
        $this->authenticatorFactory = $authenticatorFactory;
        $this->actorStorage = $actorStorage;
    }

    /**
     * @inheritDoc
     */
    public function createAuthenticator(string $type): AuthenticatorInterface
    {
        return $this->authenticatorFactory->build($type)
            ->setActorStorage($this->actorStorage);
    }

    /**
     * @inheritDoc
     */
    public function getRepository(string $entity): RepositoryInterface
    {
        return $this->registry->getRepository($entity);
    }

    /**
     * @inheritDoc
     */
    public function send(MessageInterface $message): MessageInterface
    {
        return $this->transport->send($message);
    }

    /**
     * @inheritDoc
     */
    public function getApplication(): ?Application
    {
        return $this->actorStorage->getApplication();
    }

    /**
     * @inheritDoc
     */
    public function getUser(): ?User
    {
        return $this->actorStorage->getUser();
    }

    /**
     * @inheritDoc
     */
    public function getTokenStorage(): TokenStorageInterface
    {
        return $this->transport->getTokenStorage();
    }
}
