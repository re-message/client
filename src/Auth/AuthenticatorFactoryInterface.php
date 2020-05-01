<?php

namespace RM\Component\Client\Auth;

/**
 * Interface AuthenticatorFactoryInterface
 *
 * @package RM\Component\Client\Auth
 * @author  h1karo <h1karo@outlook.com>
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
