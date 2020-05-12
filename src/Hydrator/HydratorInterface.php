<?php

namespace RM\Component\Client\Hydrator;

/**
 * Interface HydratorInterface
 *
 * @package RM\Component\Client\Hydrator
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
interface HydratorInterface
{
    /**
     * Creates a object by class name and data.
     *
     * @param array  $data
     * @param string $class
     *
     * @return mixed
     */
    public function hydrate(array $data, string $class);

    /**
     * Checks that current hydrator supports this data and class.
     *
     * @param array  $data
     * @param string $class
     *
     * @return bool
     */
    public function supports(array $data, string $class): bool;
}
