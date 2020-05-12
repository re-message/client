<?php

namespace RM\Component\Client\Security\Storage;

/**
 * Interface TokenStorageInterface
 *
 * @package RM\Component\Client\Security\Storage
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
interface TokenStorageInterface
{
    /**
     * Sets the token into storage by type.
     *
     * @param string $type
     * @param string $token
     */
    public function set(string $type, string $token): void;

    /**
     * Get the token by type.
     *
     * @param string $type
     *
     * @return string
     */
    public function get(string $type): string;

    /**
     * Checks that token is exist.
     *
     * @param string $type
     *
     * @return bool
     */
    public function has(string $type): bool;
}
