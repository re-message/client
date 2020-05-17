<?php

namespace RM\Component\Client\Security\Credentials;

use Serializable;

/**
 * Interface AuthorizationInterface
 *
 * @package RM\Component\Client\Security\Credentials
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
interface AuthorizationInterface extends Serializable
{
    /**
     * Is this authorization is complete.
     *
     * @return bool
     */
    public function isAuthorized(): bool;

    /**
     * Change authorization status.
     *
     * @param bool $authorized
     */
    public function setAuthorized(bool $authorized): void;
}
