<?php

namespace RM\Component\Client;

use RM\Component\Client\Hydrator\EntityHydrator;
use RM\Component\Client\Hydrator\HydratorInterface;
use RM\Component\Client\Repository\RepositoryFactory;
use RM\Component\Client\Repository\RepositoryFactoryInterface;
use RM\Component\Client\Security\Authenticator\AuthenticatorFactory;
use RM\Component\Client\Security\Authenticator\AuthenticatorFactoryInterface;
use RM\Component\Client\Transport\TransportInterface;

/**
 * Class ClientFactory
 *
 * @package RM\Component\Client
 * @author  h1karo <h1karo@outlook.com>
 */
class ClientFactory
{
    private TransportInterface $transport;
    private ?RepositoryFactoryInterface $repositoryFactory = null;
    private ?HydratorInterface $hydrator = null;
    private ?RepositoryRegistryInterface $repositoryRegistry = null;
    private ?AuthenticatorFactoryInterface $authenticatorFactory = null;

    public function __construct(TransportInterface $transport)
    {
        $this->transport = $transport;
    }

    public static function create(TransportInterface $transport): self
    {
        return new self($transport);
    }

    public function setTransport(TransportInterface $transport): self
    {
        $this->transport = $transport;
        return $this;
    }

    public function setHydrator(HydratorInterface $hydrator): ClientFactory
    {
        $this->hydrator = $hydrator;
        $this->repositoryFactory = null;
        return $this;
    }

    public function setRepositoryFactory(RepositoryFactoryInterface $repositoryFactory): self
    {
        $this->repositoryFactory = $repositoryFactory;
        $this->repositoryRegistry = null;
        return $this;
    }

    public function setRepositoryRegistry(RepositoryRegistryInterface $repositoryRegistry): self
    {
        $this->repositoryRegistry = $repositoryRegistry;
        $this->hydrator = null;
        $this->repositoryFactory = null;
        return $this;
    }

    public function setAuthenticatorFactory(AuthenticatorFactoryInterface $authenticatorFactory): ClientFactory
    {
        $this->authenticatorFactory = $authenticatorFactory;
        return $this;
    }

    public function build(): ClientInterface
    {
        if ($this->hydrator === null) {
            $this->hydrator = new EntityHydrator();
        }

        if ($this->repositoryFactory === null) {
            $this->repositoryFactory = new RepositoryFactory($this->transport, $this->hydrator);
        }

        if ($this->repositoryRegistry === null) {
            $this->repositoryRegistry = new RepositoryRegistry($this->repositoryFactory);
        }

        if ($this->authenticatorFactory === null) {
            $this->authenticatorFactory = new AuthenticatorFactory(
                $this->transport, $this->transport->getTokenStorage()
            );
        }

        return new Client($this->transport, $this->repositoryRegistry, $this->authenticatorFactory);
    }
}
