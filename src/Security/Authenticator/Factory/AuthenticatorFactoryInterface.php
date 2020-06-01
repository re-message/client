<?php

namespace RM\Component\Client\Security\Authenticator\Factory;

use RM\Component\Client\Security\Authenticator\AuthenticatorInterface;

/**
 * Interface AuthenticatorFactoryInterface
 *
 * @package RM\Component\Client\Security\Authenticator\Factory
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
interface AuthenticatorFactoryInterface
{
    /**
     * Builds the authenticator by type.
     *
     * @param string $type
     *
     * @return AuthenticatorInterface
     */
    public function build(string $type): AuthenticatorInterface;
}
