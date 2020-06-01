<?php

namespace RM\Component\Client\Security\Storage;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use RM\Component\Client\Security\Credentials\AuthorizationInterface;
use RM\Component\Client\Security\Credentials\NullAuthorization;

/**
 * Class RuntimeAuthorizationStorage
 *
 * @package RM\Component\Client\Security\Storage
 * @author  Oleg Kozlov <h1karo@outlook.com>
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
