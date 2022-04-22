<?php
/*
 * This file is a part of Re Message Client.
 * This package is a part of Re Message.
 *
 * @link      https://github.com/re-message/client
 * @link      https://dev.remessage.ru/packages/client
 * @copyright Copyright (c) 2018-2022 Re Message
 * @author    Oleg Kozlov <h1karo@remessage.ru>
 * @license   Apache License 2.0
 * @license   https://legal.remessage.ru/licenses/client
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RM\Component\Client;

use Psr\EventDispatcher\EventDispatcherInterface;
use RM\Component\Client\Hydrator\EntityHydrator;
use RM\Component\Client\Hydrator\EventfulHydrator;
use RM\Component\Client\Hydrator\HydratorInterface;
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
use RM\Component\Client\Transport\EventfulTransport;
use RM\Component\Client\Transport\TransportInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * @author Oleg Kozlov <h1karo@remessage.ru>
 */
class ClientFactory
{
    public const CONFIG_PATH = 'config/actions.yaml';

    private EventDispatcherInterface $eventDispatcher;

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
        $this->eventDispatcher = new EventDispatcher();
    }

    public static function create(TransportInterface $transport): static
    {
        return new static($transport);
    }

    protected function createTransport(EventDispatcherInterface $eventDispatcher): TransportInterface
    {
        return new EventfulTransport($this->transport, $eventDispatcher);
    }

    public function setTransport(TransportInterface $transport): static
    {
        $this->transport = $transport;

        return $this;
    }

    public function getEventDispatcher(): EventDispatcherInterface
    {
        return $this->eventDispatcher;
    }

    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher): static
    {
        $this->eventDispatcher = $eventDispatcher;

        return $this;
    }

    protected function createHydrator(EventDispatcherInterface $eventDispatcher): HydratorInterface
    {
        $hydrator = $this->hydrator;
        if (null === $this->hydrator) {
            $hydrator = new EntityHydrator();
        }

        return new EventfulHydrator($hydrator, $eventDispatcher);
    }

    public function setHydrator(HydratorInterface $hydrator): static
    {
        $this->hydrator = $hydrator;

        return $this;
    }

    protected function createRepositoryFactory(
        TransportInterface $transport,
        HydratorInterface $hydrator
    ): RepositoryFactoryInterface {
        if (null === $this->repositoryFactory) {
            return new RepositoryFactory($transport, $hydrator);
        }

        return $this->repositoryFactory;
    }

    public function setRepositoryFactory(RepositoryFactoryInterface $repositoryFactory): static
    {
        $this->repositoryFactory = $repositoryFactory;

        return $this;
    }

    protected function createRepositoryRegistry(RepositoryFactoryInterface $repositoryFactory): RepositoryRegistryInterface
    {
        if (null === $this->repositoryRegistry) {
            return new RepositoryRegistry($repositoryFactory);
        }

        return $this->repositoryRegistry;
    }

    public function setRepositoryRegistry(RepositoryRegistryInterface $repositoryRegistry): static
    {
        $this->repositoryRegistry = $repositoryRegistry;

        return $this;
    }

    protected function createAuthenticatorFactory(
        TransportInterface $transport,
        HydratorInterface $hydrator,
        AuthorizationStorageInterface $authorizationStorage
    ): AuthenticatorFactoryInterface {
        if (null === $this->authenticatorFactory) {
            $baseFactory = new BaseAuthenticatorFactory($transport, $hydrator, $authorizationStorage);

            return new AliasedAuthenticatorFactory($baseFactory);
        }

        return $this->authenticatorFactory;
    }

    public function setAuthenticatorFactory(AuthenticatorFactoryInterface $authenticatorFactory): static
    {
        $this->authenticatorFactory = $authenticatorFactory;

        return $this;
    }

    protected function createAuthorizationStorage(): AuthorizationStorageInterface
    {
        return $this->authorizationStorage ?? new RuntimeAuthorizationStorage();
    }

    public function setAuthorizationStorage(AuthorizationStorageInterface $authorizationStorage): static
    {
        $this->authorizationStorage = $authorizationStorage;

        return $this;
    }

    protected function createConfigLoader(): LoaderInterface
    {
        if (null === $this->configLoader) {
            $packageDir = dirname(__DIR__);
            $locator = new FileLocator($packageDir);

            return new YamlLoader($locator);
        }

        return $this->configLoader;
    }

    public function setConfigLoader(LoaderInterface $configLoader): static
    {
        $this->configLoader = $configLoader;

        return $this;
    }

    protected function createAuthorizationResolver(
        AuthorizationStorageInterface $authorizationStorage,
        LoaderInterface $configLoader
    ): AuthorizationResolverInterface {
        if (null === $this->authorizationResolver) {
            return new FileResolver($authorizationStorage, $configLoader, self::CONFIG_PATH);
        }

        return $this->authorizationResolver;
    }

    public function setAuthorizationResolver(AuthorizationResolverInterface $authorizationResolver): static
    {
        $this->authorizationResolver = $authorizationResolver;

        return $this;
    }

    public function build(): ClientInterface
    {
        $transport = $this->createTransport($this->getEventDispatcher());
        $authorizationStorage = $this->createAuthorizationStorage();
        $configLoader = $this->createConfigLoader();
        $authorizationResolver = $this->createAuthorizationResolver($authorizationStorage, $configLoader);
        $transport->setResolver($authorizationResolver);
        $hydrator = $this->createHydrator($this->getEventDispatcher());
        $repositoryFactory = $this->createRepositoryFactory($transport, $hydrator);
        $repositoryRegistry = $this->createRepositoryRegistry($repositoryFactory);

        $authenticatorFactory = $this->createAuthenticatorFactory($transport, $hydrator, $authorizationStorage);

        return new Client($transport, $repositoryRegistry, $authenticatorFactory, $authorizationStorage);
    }
}
