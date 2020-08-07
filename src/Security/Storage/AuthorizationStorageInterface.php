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

namespace RM\Component\Client\Security\Storage;

use RM\Component\Client\Security\Credentials\AuthorizationInterface;

/**
 * Interface AuthorizationStorageInterface provide ability to store the authorization data.
 *
 * @author Oleg Kozlov <h1karo@relmsg.ru>
 */
interface AuthorizationStorageInterface
{
    /**
     * Sets the authorization into storage by type.
     *
     * @param string                 $type
     * @param AuthorizationInterface $auth
     */
    public function set(string $type, AuthorizationInterface $auth): void;

    /**
     * Get the authorization by type.
     *
     * @param string $type
     *
     * @return AuthorizationInterface
     */
    public function get(string $type): AuthorizationInterface;

    /**
     * Checks that authorization is exist.
     *
     * @param string $type
     *
     * @return bool
     */
    public function has(string $type): bool;
}
