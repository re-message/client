<?php

namespace RM\Component\Client\Entity;

/**
 * Interface Identifiable
 *
 * @package RM\Component\Client\Entity
 * @author  h1karo <h1karo@outlook.com>
 */
interface Identifiable
{
    /**
     * Returns unique identifier of entity.
     *
     * @return string
     */
    public function getId(): string;
}
