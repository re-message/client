<?php

namespace RM\Component\Client\Security\Storage;

use RM\Component\Client\Security\Credentials\AuthorizationInterface;

/**
 * Interface AuthorizationStorageInterface
 *
 * @package RM\Component\Client\Security\Storage
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
interface AuthorizationStorageInterface
{
    /**
     * Sets the authorization into storage by type.
     *
     * @param string                 $type
     * @param AuthorizationInterface $auth
     */
    public function set(string $type, AuthorizationInterface $auth): void;

    /**
     * Get the authorization by type.
     *
     * @param string $type
     *
     * @return AuthorizationInterface
     */
    public function get(string $type): AuthorizationInterface;

    /**
     * Checks that authorization is exist.
     *
     * @param string $type
     *
     * @return bool
     */
    public function has(string $type): bool;
}
