<?php

namespace RM\Component\Client\Repository\Factory;

use RM\Component\Client\Repository\RepositoryInterface;

/**
 * Interface RepositoryFactoryInterface
 *
 * @package RM\Component\Client\Repository\Factory
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
