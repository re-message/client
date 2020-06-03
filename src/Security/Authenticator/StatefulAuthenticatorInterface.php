<?php

namespace RM\Component\Client\Security\Authenticator;

/**
 * Interface StatefulAuthenticatorInterface provide ability to store and restore authenticator state.
 *
 * @package RM\Component\Client\Security\Authenticator
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
interface StatefulAuthenticatorInterface extends StorableAuthenticatorInterface
{
    /**
     * Saves the state of authenticator in storage.
     *
     * @return static
     */
    public function store(): self;

    /**
     * Restore state of authenticator from storage.
     *
     * @return static
     */
    public function restore(): self;

    /**
     * Clears state of authenticator.
     * This method can clear the state stored in the storage.
     *
     * @return static
     */
    public function clear(): self;
}
