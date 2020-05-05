<?php

namespace RM\Component\Client\Repository;

/**
 * Interface RepositoryRegistryInterface
 *
 * @package RM\Component\Client
 * @author  h1karo <h1karo@outlook.com>
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
