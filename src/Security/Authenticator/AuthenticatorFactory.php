<?php

namespace RM\Component\Client\Security\Authenticator;

use InvalidArgumentException;
use RM\Component\Client\Hydrator\HydratorInterface;
use RM\Component\Client\Security\Storage\TokenStorageInterface;
use RM\Component\Client\Transport\TransportInterface;

/**
 * Class AuthenticatorFactory
 *
 * @package RM\Component\Client\Security\Authenticator
 * @author  h1karo <h1karo@outlook.com>
 */
class AuthenticatorFactory implements AuthenticatorFactoryInterface
{
    public const PROVIDERS = [
        ServiceAuthenticator::TOKEN_TYPE => ServiceAuthenticator::class
    ];

    private TransportInterface $transport;
    private HydratorInterface $hydrator;
    private TokenStorageInterface $tokenStorage;

    public function __construct(TransportInterface $transport, HydratorInterface $hydrator, TokenStorageInterface $tokenStorage)
    {
        $this->transport = $transport;
        $this->hydrator = $hydrator;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @inheritDoc
     */
    public function build(string $type): AuthenticatorInterface
    {
        $provider = self::PROVIDERS[$type] ?? null;
        if ($provider === null) {
            throw new InvalidArgumentException(sprintf('Authorization provider with name `%s` does not exist.', $type));
        }

        return $provider($this->transport, $this->hydrator, $this->tokenStorage);
    }
}
