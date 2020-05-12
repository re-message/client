<?php

namespace RM\Component\Client\Security\Authenticator;

/**
 * Interface AuthenticatorFactoryInterface
 *
 * @package RM\Component\Client\Security\Authenticator
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
