<?php

namespace RM\Component\Client\Repository;

/**
 * Interface RepositoryFactoryInterface
 *
 * @package RM\Component\Client\Repository
 * @author  h1karo <h1karo@outlook.com>
 */
interface RepositoryFactoryInterface
{
    /**
     * Builds the repository by entity class.
     *
     * @return RepositoryInterface
     */
    public function build(string $entity): RepositoryInterface;
}
