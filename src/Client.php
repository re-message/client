<?php

namespace RM\Component\Client;

use RM\Component\Client\Repository\RepositoryInterface;
use RM\Component\Client\Repository\RepositoryRegistryInterface;
use RM\Component\Client\Security\Authenticator\AuthenticatorFactoryInterface;
use RM\Component\Client\Security\Authenticator\AuthenticatorInterface;
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

    /**
     * @inheritDoc
     */
    public function createAuthenticator(string $type): AuthenticatorInterface
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
}
