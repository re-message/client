<?php
/*
 * This file is a part of Relations Messenger Client.
 * This package is a part of Relations Messenger.
 *
 * @link      https://github.com/relmsg/client
 * @link      https://dev.relmsg.ru/packages/client
 * @copyright Copyright (c) 2018-2022 Relations Messenger
 * @author    Oleg Kozlov <h1karo@relmsg.ru>
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
 * @author Oleg Kozlov <h1karo@relmsg.ru>
 */
interface RedirectAuthenticatorInterface extends AuthenticatorInterface
{
    /**
     * Sets factory in authenticator to use him inside.
     */
    public function setFactory(AuthenticatorFactoryInterface $authenticatorFactory): static;

    /**
     * Returns a next authenticator.
     *
     * {@inheritdoc}
     */
    public function authenticate(): AuthenticatorInterface;
}
