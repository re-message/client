<?php

namespace RM\Component\Client\Entity;

use Closure;
use RM\Component\Client\Annotation\Entity;
use RM\Component\Client\Annotation\LazyLoad;
use RM\Component\Client\Repository\ApplicationRepository;

/**
 * Class Application
 *
 * @Entity(repositoryClass=ApplicationRepository::class)
 *
 * @package RM\Component\Client\Entity
 * @author  h1karo <h1karo@outlook.com>
 */
class Application implements CreatableFromArray, Identifiable
{
    private string $id;
    private string $name;
    private string $ownerId;

    private Closure $ownerReference;

    public function __construct(string $id, string $name, string $ownerId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->ownerId = $ownerId;
    }

    /**
     * @inheritDoc
     */
    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Application
    {
        $this->name = $name;
        return $this;
    }

    public function getOwnerId(): string
    {
        return $this->ownerId;
    }

    public function setOwnerId(string $ownerId): Application
    {
        $this->ownerId = $ownerId;
        return $this;
    }

    public function getOwner(): User
    {
        return call_user_func($this->ownerReference, $this->getOwnerId());
    }

    /**
     * @LazyLoad(entity=User::class)
     *
     * @param Closure $ownerReference
     *
     * @internal
     */
    public function setOwner(Closure $ownerReference): void
    {
        $this->ownerReference = $ownerReference;
    }

    /**
     * @inheritDoc
     */
    public static function createFromArray(array $array): self
    {
        return new self($array['id'], $array['name'], $array['owner']);
    }
}
