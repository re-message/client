<?php

namespace RM\Component\Client\Hydrator;

/**
 * Interface HydratorLoaderInterface
 *
 * @package RM\Component\Client\Hydrator
 * @author  h1karo <h1karo@outlook.com>
 */
interface HydratorLoaderInterface
{
    /**
     * @param mixed $entity
     *
     * @return mixed
     */
    public function load($entity);

    /**
     * Checks that loader supports this hydrator and entity.
     *
     * @param HydratorInterface $hydrator
     * @param mixed             $entity
     *
     * @return bool
     */
    public function supports(HydratorInterface $hydrator, $entity): bool;
}
