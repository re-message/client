<?php
/*
 * This file is a part of Relations Messenger Client.
 * This package is a part of Relations Messenger.
 *
 * @link      https://github.com/relmsg/client
 * @link      https://dev.relmsg.ru/packages/client
 * @copyright Copyright (c) 2018-2020 Relations Messenger
 * @author    Oleg Kozlov <h1karo@outlook.com>
 * @license   https://legal.relmsg.ru/licenses/client
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RM\Component\Client\Security\Authenticator;

use RM\Component\Client\Security\Authenticator\Factory\AuthenticatorFactoryInterface;

/**
 * Interface RedirectAuthenticatorInterface provides ability to redirect to another authenticator on 2-step
 * authentication.
 *
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
