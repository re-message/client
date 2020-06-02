<?php

namespace RM\Component\Client\Security\Authenticator;

use RM\Component\Client\Security\Storage\AuthorizationStorageInterface;

/**
 * Interface StorableAuthenticatorInterface
 *
 * @package RM\Component\Client\Security\Authenticator
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
interface StorableAuthenticatorInterface extends AuthenticatorInterface
{
    /**
     * Configures storage to use in authenticator.
     *
     * @param AuthorizationStorageInterface $storage
     *
     * @return static
     */
    public function setStorage(AuthorizationStorageInterface $storage): self;
}
