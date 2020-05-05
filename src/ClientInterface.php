<?php

namespace RM\Component\Client;

use RM\Component\Client\Security\Authenticator\AuthenticatorInterface;
use RM\Component\Client\Transport\TransportInterface;

/**
 * Interface ClientInterface
 *
 * @package RM\Component\Client
 * @author  h1karo <h1karo@outlook.com>
 */
interface ClientInterface extends RepositoryRegistryInterface, TransportInterface
{
    /**
     * Creates authenticator by the token type.
     *
     * @param string $type The token type (e.g. `user` for user token).
     *
     * @return AuthenticatorInterface
     */
    public function createAuthenticator(string $type): AuthenticatorInterface;
}
