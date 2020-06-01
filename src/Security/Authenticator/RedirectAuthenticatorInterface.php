<?php

namespace RM\Component\Client\Security\Authenticator;

use RM\Component\Client\Security\Authenticator\Factory\AuthenticatorFactoryInterface;

/**
 * Interface RedirectAuthenticatorInterface
 *
 * @package RM\Component\Client\Security\Authenticator
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
interface RedirectAuthenticatorInterface extends AuthenticatorInterface
{
    /**
     * Sets factory in authenticator to use him inside.
     *
     * @param AuthenticatorFactoryInterface $authenticatorFactory
     *
     * @return $this
     */
    public function setFactory(AuthenticatorFactoryInterface $authenticatorFactory): self;

    /**
     * Returns a next authenticator.
     *
     * @inheritDoc
     */
    public function authenticate(): AuthenticatorInterface;
}
