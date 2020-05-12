<?php

namespace RM\Component\Client\Hydrator;

use RM\Component\Client\Entity\CreatableFromArray;

/**
 * Class EntityHydrator
 *
 * @package RM\Component\Client\Hydrator
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
class EntityHydrator implements HydratorInterface
{
    /**
     * @inheritDoc
     */
    public function hydrate(array $data, string $class): object
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
