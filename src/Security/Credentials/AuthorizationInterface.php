<?php

namespace RM\Component\Client\Security\Credentials;

/**
 * Interface AuthorizationInterface provides authorization state.
 *
 * @package RM\Component\Client\Security\Credentials
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
interface AuthorizationInterface
{
    /**
     * Is authorization completed.
     *
     * @return bool
     */
    public function isCompleted(): bool;

    /**
     * Returns the authorization credentials (e.g. token).
     *
     * @return string
     */
    public function getCredentials(): string;

    /**
     * Returns state as array.
     *
     * @return array
     */
    public function __serialize(): array;

    /**
     * Restores state from array.
     *
     * @param array $data
     */
    public function __unserialize(array $data): void;
}
