<?php

namespace RM\Component\Client\Hydrator\Handler;

use RM\Component\Client\Hydrator\HydratorInterface;

/**
 * Interface HydratorHandlerInterface\Handler
 *
 * @package RM\Component\Client\Hydrator
 * @author  h1karo <h1karo@outlook.com>
 */
interface HydratorHandlerInterface
{
    /**
     * @param mixed $entity
     *
     * @return mixed
     */
    public function handle($entity);

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
