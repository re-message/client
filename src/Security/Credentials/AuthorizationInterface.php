<?php
/*
 * This file is a part of Relations Messenger Client.
 * This package is a part of Relations Messenger.
 *
 * @link      https://github.com/relmsg/client
 * @link      https://dev.relmsg.ru/packages/client
 * @copyright Copyright (c) 2018-2020 Relations Messenger
 * @author    Oleg Kozlov <h1karo@relmsg.ru>
 * @license   https://legal.relmsg.ru/licenses/client
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RM\Component\Client\Security\Credentials;

/**
 * Interface AuthorizationInterface provides authorization state.
 *
 * @author  Oleg Kozlov <h1karo@relmsg.ru>
 */
interface AuthorizationInterface
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

    /**
     * Returns state as array.
     *
     * @return array
     */
    public function __serialize(): array;

    /**
     * Restores state from array.
     *
     * @param array $data
     */
    public function __unserialize(array $data): void;
}
