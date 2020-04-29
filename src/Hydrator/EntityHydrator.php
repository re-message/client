<?php

namespace RM\Component\Client\Hydrator;

use RM\Component\Client\Entity\CreatableFromArray;

/**
 * Class EntityHydrator
 *
 * @package RM\Component\Client\Hydrator
 * @author  h1karo <h1karo@outlook.com>
 */
class EntityHydrator extends AbstractHydrator
{
    /**
     * @inheritDoc
     */
    public function doHydrate(array $data, string $class): object
    {
        if (is_subclass_of($class, CreatableFromArray::class, true)) {
            return call_user_func([$class, 'createFromArray'], $data);
        }

        return new $class(...$data);
    }

    /**
     * @inheritDoc
     */
    public function supports(array $data, string $class): bool
    {
        return class_exists($class);
    }
}
