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

namespace RM\Component\Client\Security\Storage;

use RM\Component\Client\Security\Credentials\AuthorizationInterface;

/**
 * Interface AuthorizationStorageInterface provide ability to store the authorization data.
 *
 * @author Oleg Kozlov <h1karo@remessage.ru>
 */
interface AuthorizationStorageInterface
{
    /**
     * Sets the authorization into storage by type.
     */
    public function set(string $type, AuthorizationInterface $auth): void;

    /**
     * Get the authorization by type.
     */
    public function get(string $type): AuthorizationInterface;

    /**
     * Checks that authorization is exists.
     */
    public function has(string $type): bool;
}
