<?php

namespace RM\Component\Client\Entity;

use RM\Component\Client\Annotation\Entity;
use RM\Component\Client\Repository\UserRepository;

/**
 * Class User
 *
 * @Entity(repositoryClass=UserRepository::class)
 *
 * @package RM\Component\Client\Entity
 * @author  h1karo <h1karo@outlook.com>
 */
class User implements CreatableFromArray, Identifiable
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @inheritDoc
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public static function createFromArray(array $array): self
    {
        return new self($array['id']);
    }
}
