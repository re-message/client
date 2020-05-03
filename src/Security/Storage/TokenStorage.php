<?php

namespace RM\Component\Client\Security\Storage;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Class TokenStorage
 *
 * @package RM\Component\Client\Security\Storage
 * @author  h1karo <h1karo@outlook.com>
 */
class TokenStorage implements TokenStorageInterface
{
    private Collection $storage;

    public function __construct()
    {
        $this->storage = new ArrayCollection();
    }

    /**
     * @inheritDoc
     */
    public function set(string $type, string $token): void
    {
        $this->storage->set($type, $token);
    }

    /**
     * @inheritDoc
     */
    public function get(string $type): ?string
    {
        return $this->storage->get($type);
    }

    /**
     * @inheritDoc
     */
    public function has(string $type): bool
    {
        return $this->storage->containsKey($type);
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        return $this->storage->getIterator();
    }
}
