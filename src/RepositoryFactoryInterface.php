<?php

namespace RM\Component\Client;

use RM\Component\Client\Repository\RepositoryInterface;

/**
 * Interface RepositoryFactoryInterface
 *
 * @package RM\Component\Client
 * @author  h1karo <h1karo@outlook.com>
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
