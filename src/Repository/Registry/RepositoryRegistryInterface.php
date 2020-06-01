<?php

namespace RM\Component\Client\Repository\Registry;

use RM\Component\Client\Repository\RepositoryInterface;

/**
 * Interface RepositoryRegistryInterface
 *
 * @package RM\Component\Client\Repository\Registry
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
interface RepositoryRegistryInterface
{
    /**
     * Returns entity repository.
     *
     * @param string $entity
     *
     * @return RepositoryInterface
     */
    public function getRepository(string $entity): RepositoryInterface;
}
