<?php
/*
 * This file is a part of Relations Messenger Client.
 * This package is a part of Relations Messenger.
 *
 * @link      https://github.com/relmsg/client
 * @link      https://dev.relmsg.ru/packages/client
 * @copyright Copyright (c) 2018-2022 Relations Messenger
 * @author    Oleg Kozlov <h1karo@relmsg.ru>
 * @license   https://legal.relmsg.ru/licenses/client
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
 * @author Oleg Kozlov <h1karo@relmsg.ru>
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
     * {@inheritdoc}
     */
    public function createAuthenticator(string $type): AuthenticatorInterface
    {
        return $this->authenticatorFactory->build($type);
    }

    /**
     * {@inheritdoc}
     */
    public function getRepository(string $entity): RepositoryInterface
    {
        return $this->registry->getRepository($entity);
    }

    /**
     * {@inheritdoc}
     */
    public function send(MessageInterface $message): MessageInterface
    {
        return $this->transport->send($message);
    }

    /**
     * {@inheritdoc}
     *
     * @internal
     */
    public function setResolver(AuthorizationResolverInterface $resolver): self
    {
        return $this;
    }

    /**
     * {@inheritdoc}
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

        return $repository->find($auth->getObjectId());
    }

    /**
     * {@inheritdoc}
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

        return $repository->find($auth->getObjectId());
    }
}
