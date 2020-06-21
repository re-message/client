<?php

namespace RM\Component\Client;

use RM\Component\Client\Hydrator\EntityHydrator;
use RM\Component\Client\Hydrator\HydratorInterface;
use RM\Component\Client\Hydrator\LazyLoaderHydrator;
use RM\Component\Client\Repository\Factory\RepositoryFactory;
use RM\Component\Client\Repository\Factory\RepositoryFactoryInterface;
use RM\Component\Client\Repository\Registry\RepositoryRegistry;
use RM\Component\Client\Repository\Registry\RepositoryRegistryInterface;
use RM\Component\Client\Security\Authenticator\Factory\AliasedAuthenticatorFactory;
use RM\Component\Client\Security\Authenticator\Factory\AuthenticatorFactoryInterface;
use RM\Component\Client\Security\Authenticator\Factory\BaseAuthenticatorFactory;
use RM\Component\Client\Security\Loader\LoaderInterface;
use RM\Component\Client\Security\Loader\YamlLoader;
use RM\Component\Client\Security\Resolver\AuthorizationResolverInterface;
use RM\Component\Client\Security\Resolver\FileResolver;
use RM\Component\Client\Security\Storage\AuthorizationStorageInterface;
use RM\Component\Client\Security\Storage\RuntimeAuthorizationStorage;
use RM\Component\Client\Transport\TransportInterface;
use Symfony\Component\Config\FileLocator;

/**
 * Class ClientFactory
 *
 * @package RM\Component\Client
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
class ClientFactory
{
    public const CONFIG_PATH = 'Resources/config/actions.yaml';

    private TransportInterface $transport;

    private ?HydratorInterface $hydrator = null;

    private ?RepositoryFactoryInterface $repositoryFactory = null;
    private ?RepositoryRegistryInterface $repositoryRegistry = null;

    private ?AuthenticatorFactoryInterface $authenticatorFactory = null;
    private ?AuthorizationStorageInterface $authorizationStorage = null;

    private ?LoaderInterface $configLoader = null;
    private ?AuthorizationResolverInterface $authorizationResolver = null;

    public function __construct(TransportInterface $transport)
    {
        $this->transport = $transport;
    }

    public static function create(TransportInterface $transport): self
    {
        return new self($transport);
    }

    protected function getTransport(): TransportInterface
    {
        return $this->transport;
    }

    public function setTransport(TransportInterface $transport): self
    {
        $this->transport = $transport;
        return $this;
    }

    protected function getHydrator(): HydratorInterface
    {
        if ($this->hydrator === null) {
            $hydrator = new EntityHydrator();
            return new LazyLoaderHydrator($hydrator);
        }

        return $this->hydrator;
    }

    public function setHydrator(HydratorInterface $hydrator): ClientFactory
    {
        $this->hydrator = $hydrator;
        return $this;
    }

    protected function getRepositoryFactory(
        TransportInterface $transport,
        HydratorInterface $hydrator
    ): RepositoryFactoryInterface {
        if ($this->repositoryFactory === null) {
            return new RepositoryFactory($transport, $hydrator);
        }

        return $this->repositoryFactory;
    }

    public function setRepositoryFactory(RepositoryFactoryInterface $repositoryFactory): self
    {
        $this->repositoryFactory = $repositoryFactory;
        return $this;
    }

    protected function getRepositoryRegistry(RepositoryFactoryInterface $repositoryFactory): RepositoryRegistryInterface
    {
        if ($this->repositoryRegistry === null) {
            return new RepositoryRegistry($repositoryFactory);
        }

        return $this->repositoryRegistry;
    }

    public function setRepositoryRegistry(RepositoryRegistryInterface $repositoryRegistry): self
    {
        $this->repositoryRegistry = $repositoryRegistry;
        return $this;
    }

    protected function getAuthenticatorFactory(
        TransportInterface $transport,
        HydratorInterface $hydrator,
        AuthorizationStorageInterface $authorizationStorage
    ): AuthenticatorFactoryInterface {
        if ($this->authenticatorFactory === null) {
            $baseFactory = new BaseAuthenticatorFactory($transport, $hydrator, $authorizationStorage);
            return new AliasedAuthenticatorFactory($baseFactory);
        }

        return $this->authenticatorFactory;
    }

    public function setAuthenticatorFactory(AuthenticatorFactoryInterface $authenticatorFactory): self
    {
        $this->authenticatorFactory = $authenticatorFactory;
        return $this;
    }

    protected function getAuthorizationStorage(): AuthorizationStorageInterface
    {
        return $this->authorizationStorage ?? new RuntimeAuthorizationStorage();
    }

    public function setAuthorizationStorage(AuthorizationStorageInterface $authorizationStorage): self
    {
        $this->authorizationStorage = $authorizationStorage;
        return $this;
    }

    protected function getConfigLoader(): LoaderInterface
    {
        if ($this->configLoader === null) {
            $locator = new FileLocator(__DIR__);
            return new YamlLoader($locator);
        }

        return $this->configLoader;
    }

    public function setConfigLoader(LoaderInterface $configLoader): ClientFactory
    {
        $this->configLoader = $configLoader;
        return $this;
    }

    protected function getAuthorizationResolver(
        AuthorizationStorageInterface $authorizationStorage,
        LoaderInterface $configLoader
    ): AuthorizationResolverInterface {
        if ($this->authorizationResolver === null) {
            return new FileResolver($authorizationStorage, $configLoader, self::CONFIG_PATH);
        }

        return $this->authorizationResolver;
    }

    public function setAuthorizationResolver(AuthorizationResolverInterface $authorizationResolver): self
    {
        $this->authorizationResolver = $authorizationResolver;
        return $this;
    }

    public function build(): ClientInterface
    {
        $transport = $this->getTransport();
        $authorizationStorage = $this->getAuthorizationStorage();
        $configLoader = $this->getConfigLoader();
        $authorizationResolver = $this->getAuthorizationResolver($authorizationStorage, $configLoader);
        $transport->setResolver($authorizationResolver);
        $hydrator = $this->getHydrator();
        $repositoryFactory = $this->getRepositoryFactory($transport, $hydrator);
        $repositoryRegistry = $this->getRepositoryRegistry($repositoryFactory);

        if ($hydrator instanceof LazyLoaderHydrator) {
            $hydrator->setRepositoryRegistry($repositoryRegistry);
        }

        $authenticatorFactory = $this->getAuthenticatorFactory($transport, $hydrator, $authorizationStorage);

        return new Client($transport, $repositoryRegistry, $authenticatorFactory, $authorizationStorage);
    }
}
