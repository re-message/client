<?php

namespace RM\Component\Client\Security\Credentials;

use Serializable;

/**
 * Interface AuthorizationInterface provides authorization state.
 *
 * @package RM\Component\Client\Security\Credentials
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
interface AuthorizationInterface extends Serializable
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
}
