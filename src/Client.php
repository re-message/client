<?php

namespace RM\Component\Client;

use RM\Component\Client\Entity\Application;
use RM\Component\Client\Entity\User;
use RM\Component\Client\Repository\ApplicationRepository;
use RM\Component\Client\Repository\Registry\RepositoryRegistryInterface;
use RM\Component\Client\Repository\RepositoryInterface;
use RM\Component\Client\Repository\UserRepository;
use RM\Component\Client\Security\Authenticator\AuthenticatorInterface;
use RM\Component\Client\Security\Authenticator\Factory\AuthenticatorFactoryInterface;
use RM\Component\Client\Security\Authenticator\ServiceAuthenticator;
use RM\Component\Client\Security\Authenticator\SignInAuthenticator;
use RM\Component\Client\Security\Credentials\Token;
use RM\Component\Client\Security\Resolver\AuthorizationResolverInterface;
use RM\Component\Client\Security\Storage\AuthorizationStorageInterface;
use RM\Component\Client\Transport\TransportInterface;
use RM\Standard\Message\MessageInterface;

/**
 * Class Client implements a facade pattern to simplify the use of the library.
 *
 * @package RM\Component\Client
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
class Client implements ClientInterface
{
    private TransportInterface $transport;
    private RepositoryRegistryInterface $registry;
    private AuthenticatorFactoryInterface $authenticatorFactory;
    private AuthorizationStorageInterface $authorizationStorage;

    public function __construct(
        TransportInterface $transport,
        RepositoryRegistryInterface $registry,
        AuthenticatorFactoryInterface $authenticatorFactory,
        AuthorizationStorageInterface $authorizationStorage
    ) {
        $this->transport = $transport;
        $this->registry = $registry;
        $this->authenticatorFactory = $authenticatorFactory;
        $this->authorizationStorage = $authorizationStorage;
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

    /**
     * @inheritDoc
     * @internal
     */
    public function setResolver(AuthorizationResolverInterface $resolver): self
    {
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getApplication(): ?Application
    {
        if (!$this->authorizationStorage->has(ServiceAuthenticator::getTokenType())) {
            return null;
        }

        $auth = $this->authorizationStorage->get(ServiceAuthenticator::getTokenType());
        if (!$auth instanceof Token) {
            return null;
        }

        /** @var ApplicationRepository $repository */
        $repository = $this->getRepository(Application::class);
        return $repository->get($auth->getObjectId());
    }

    /**
     * @inheritDoc
     */
    public function getUser(): ?User
    {
        if (!$this->authorizationStorage->has(SignInAuthenticator::getTokenType())) {
            return null;
        }

        $auth = $this->authorizationStorage->get(SignInAuthenticator::getTokenType());
        if (!$auth instanceof Token) {
            return null;
        }

        /** @var UserRepository $repository */
        $repository = $this->getRepository(User::class);
        return $repository->get($auth->getObjectId());
    }
}
