<?php

namespace RM\Component\Client\Security;

use InvalidArgumentException;
use RM\Component\Client\Transport\TransportInterface;

/**
 * Class AuthenticatorFactory
 *
 * @package RM\Component\Client\Security
 * @author  h1karo <h1karo@outlook.com>
 */
class AuthenticatorFactory implements AuthenticatorFactoryInterface
{
    public const PROVIDERS = [];

    private TransportInterface $transport;
    private TokenStorageInterface $tokenStorage;

    public function __construct(TransportInterface $transport, TokenStorageInterface $tokenStorage)
    {
        $this->transport = $transport;
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

        return $provider($this->transport, $this->tokenStorage);
    }
}
