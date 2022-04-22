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

namespace RM\Component\Client\Security\Credentials;

use BadMethodCallException;

/**
 * Class NullAuthorization.
 *
 * @author Oleg Kozlov <h1karo@relmsg.ru>
 */
final class NullAuthorization implements AuthorizationInterface
{
    /**
     * @inheritDoc
     */
    public function isCompleted(): bool
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function __serialize(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function __unserialize(array $serialized): void
    {
        // nothing
    }

    /**
     * @inheritDoc
     */
    public function getCredentials(): string
    {
        $message = sprintf('Do not use %s method of %s.', __FUNCTION__, self::class);

        throw new BadMethodCallException($message);
    }
}
