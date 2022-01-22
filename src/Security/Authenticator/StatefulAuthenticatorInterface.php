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

/**
 * Interface StatefulAuthenticatorInterface provide ability to store and restore authenticator state.
 *
 * @author Oleg Kozlov <h1karo@relmsg.ru>
 */
interface StatefulAuthenticatorInterface extends StorableAuthenticatorInterface
{
    /**
     * Saves the state of authenticator in storage.
     */
    public function store(): static;

    /**
     * Restore state of authenticator from storage.
     */
    public function restore(): static;

    /**
     * Clears state of authenticator.
     * This method can clear the state stored in the storage.
     */
    public function clear(): static;
}
