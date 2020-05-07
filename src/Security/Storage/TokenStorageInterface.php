<?php

namespace RM\Component\Client\Security\Storage;

use IteratorAggregate;

/**
 * Interface TokenStorageInterface
 *
 * @package RM\Component\Client\Security\Storage
 * @author  h1karo <h1karo@outlook.com>
 */
interface TokenStorageInterface extends IteratorAggregate
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
