<?php

namespace RM\Component\Client\Repository;

/**
 * Interface RepositoryFactoryInterface
 *
 * @package RM\Component\Client
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
interface RepositoryFactoryInterface
{
    /**
     * Builds the repository by entity class.
     *
     * @param string $entity
     *
     * @return RepositoryInterface
     */
    public function build(string $entity): RepositoryInterface;
}
