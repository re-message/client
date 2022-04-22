<?php
/*
 * This file is a part of Re Message Client.
 * This package is a part of Re Message.
 *
 * @link      https://github.com/re-message/client
 * @link      https://dev.remessage.ru/packages/client
 * @copyright Copyright (c) 2018-2022 Re Message
 * @author    Oleg Kozlov <h1karo@remessage.ru>
 * @license   Apache License 2.0
 * @license   https://legal.remessage.ru/licenses/client
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RM\Component\Client\Security\Authenticator;

/**
 * Interface StatefulAuthenticatorInterface provide ability to store and restore authenticator state.
 *
 * @author Oleg Kozlov <h1karo@remessage.ru>
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
