<?php

namespace RM\Component\Client\Entity;

/**
 * Interface CreatableFromArrayInterface
 *
 * @package RM\Component\Client\Entity
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
interface CreatableFromArray
{
    /**
     * Creates a new instance of class by array.
     *
     * @param array $array
     *
     * @return static
     */
    public static function createFromArray(array $array): self;
}
