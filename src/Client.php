<?php

namespace RM\Component\Client;

use RM\Component\Client\Auth\AuthenticatorFactoryInterface;
use RM\Component\Client\Auth\AuthenticatorInterface;
use RM\Component\Client\Auth\TokenStorageInterface;
use RM\Component\Client\Hydrator\EntityHydrator;
use RM\Component\Client\Hydrator\HydratorInterface;
use RM\Component\Client\Repository\RepositoryFactory;
use RM\Component\Client\Repository\RepositoryFactoryInterface;
use RM\Component\Client\Repository\RepositoryInterface;
use RM\Component\Client\Transport\TransportInterface;
use RM\Standard\Message\MessageInterface;

/**
 * Class Client
 *
 * @package RM\Component\Client
 * @author  h1karo <h1karo@outlook.com>
 */
class Client implements ClientInterface
{
    private TransportInterface $transport;
    private RepositoryRegistryInterface $registry;
    private AuthenticatorFactoryInterface $authenticatorFactory;

    public function __construct(
        TransportInterface $transport,
        RepositoryRegistryInterface $registry,
        AuthenticatorFactoryInterface $authenticatorFactory
    ) {
        $this->transport = $transport;
        $this->registry = $registry;
        $this->authenticatorFactory = $authenticatorFactory;
    }

    public function createAuthorization(string $type): AuthenticatorInterface
    {
        return $this->authenticatorFactory->build($type);
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
    public function getTokenStorage(): TokenStorageInterface
    {
        return $this->transport->getTokenStorage();
    }

    public static function createFromFactory(TransportInterface $transport, RepositoryFactoryInterface $factory): self
    {
        return new self($transport, new RepositoryRegistry($factory));
    }

    public static function createFromHydrator(TransportInterface $transport, HydratorInterface $hydrator): self
    {
        return self::createFromFactory($transport, new RepositoryFactory($transport, $hydrator));
    }

    public static function create(TransportInterface $transport): self
    {
        return self::createFromHydrator($transport, new EntityHydrator());
    }
}
