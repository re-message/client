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

namespace RM\Component\Client\Security\Storage;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use RM\Component\Client\Security\Credentials\AuthorizationInterface;
use RM\Component\Client\Security\Credentials\NullAuthorization;

/**
 * Class RuntimeAuthorizationStorage.
 *
 * @author Oleg Kozlov <h1karo@relmsg.ru>
 */
class RuntimeAuthorizationStorage implements AuthorizationStorageInterface
{
    private Collection $storage;

    public function __construct()
    {
        $this->storage = new ArrayCollection();
    }

    /**
     * @inheritDoc
     */
    public function set(string $type, AuthorizationInterface $auth): void
    {
        $this->storage->set($type, $auth);
    }

    /**
     * @inheritDoc
     */
    public function get(string $type): AuthorizationInterface
    {
        if (!$this->has($type)) {
            return new NullAuthorization();
        }

        return $this->storage->get($type);
    }

    /**
     * @inheritDoc
     */
    public function has(string $type): bool
    {
        return $this->storage->containsKey($type);
    }
}
