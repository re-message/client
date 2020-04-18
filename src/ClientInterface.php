<?php

namespace RM\Component\Client;

use RM\Component\Client\Auth\AuthenticatorInterface;
use RM\Component\Client\Transport\TransportInterface;

/**
 * Interface ClientInterface
 *
 * @package RM\Component\Client
 * @author  h1karo <h1karo@outlook.com>
 */
interface ClientInterface extends RepositoryRegistryInterface, TransportInterface
{
    public function createAuthorization(string $type): AuthenticatorInterface;
}
