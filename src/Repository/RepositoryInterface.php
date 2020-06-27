<?php

namespace RM\Component\Client\Repository;

use RM\Component\Client\Hydrator\HydratorInterface;
use RM\Component\Client\Transport\TransportInterface;

/**
 * Interface RepositoryInterface
 *
 * @package RM\Component\Client\Repository
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
interface RepositoryInterface
{
    public function __construct(TransportInterface $transport, HydratorInterface $hydrator);

    /**
     * Returns entity by identifier.
     *
     * @param string $id
     *
     * @return object
     */
    public function get(string $id): object;

    /**
     * Returns entities by identifiers.
     *
     * @param string[] $ids
     *
     * @return object[]
     */
    public function getAll(array $ids): array;

    /**
     * Returns FQCN of entity.
     *
     * @return string
     */
    public function getEntity(): string;
}
