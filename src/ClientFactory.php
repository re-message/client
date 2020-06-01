<?php

namespace RM\Component\Client;

use RM\Component\Client\Hydrator\EntityHydrator;
use RM\Component\Client\Hydrator\HydratorInterface;
use RM\Component\Client\Hydrator\LazyLoaderHydrator;
use RM\Component\Client\Repository\Factory\RepositoryFactory;
use RM\Component\Client\Repository\Factory\RepositoryFactoryInterface;
use RM\Component\Client\Repository\Registry\RepositoryRegistry;
use RM\Component\Client\Repository\Registry\RepositoryRegistryInterface;
use RM\Component\Client\Security\Authenticator\Factory\AuthenticatorFactory;
use RM\Component\Client\Security\Authenticator\Factory\AuthenticatorFactoryInterface;
use RM\Component\Client\Transport\ThrowableTransport;
use RM\Component\Client\Transport\TransportInterface;

/**
 * Class ClientFactory
 *
 * @package RM\Component\Client
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
class ClientFactory
{
    private TransportInterface $transport;
    private bool $throwable = true;
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

    public function setThrowable(bool $throwable): ClientFactory
    {
        $this->throwable = $throwable;
        return $this;
    }

    public function setHydrator(HydratorInterface $hydrator): ClientFactory
    {
        $this->hydrator = $hydrator;
        return $this;
    }

    public function setRepositoryFactory(RepositoryFactoryInterface $repositoryFactory): self
    {
        $this->repositoryFactory = $repositoryFactory;
        return $this;
    }

    public function setRepositoryRegistry(RepositoryRegistryInterface $repositoryRegistry): self
    {
        $this->repositoryRegistry = $repositoryRegistry;
        return $this;
    }

    public function setAuthenticatorFactory(AuthenticatorFactoryInterface $authenticatorFactory): self
    {
        $this->authenticatorFactory = $authenticatorFactory;
        return $this;
    }

    public function build(): ClientInterface
    {
        $transport = $this->transport;
        if ($this->throwable && !$transport instanceof ThrowableTransport) {
            $transport = new ThrowableTransport($transport);
        }

        $hydrator = $this->hydrator;
        if ($this->hydrator === null) {
            $hydrator = new EntityHydrator();
        }

        $repositoryFactory = $this->repositoryFactory;
        if ($this->repositoryFactory === null) {
            $repositoryFactory = new RepositoryFactory($transport, $hydrator);
        }

        $repositoryRegistry = $this->repositoryRegistry;
        if ($this->repositoryRegistry === null) {
            $repositoryRegistry = new RepositoryRegistry($repositoryFactory);

            if ($this->hydrator === null) {
                $hydrator = new LazyLoaderHydrator($hydrator, $repositoryRegistry);
            }
        }

        $authenticatorFactory = $this->authenticatorFactory;
        if ($this->authenticatorFactory === null) {
            $authenticatorFactory = new AuthenticatorFactory($transport, $hydrator);
        }

        return new Client($transport, $repositoryRegistry, $authenticatorFactory);
    }
}
