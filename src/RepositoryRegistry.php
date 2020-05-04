<?php

namespace RM\Component\Client;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use RM\Component\Client\Repository\RepositoryInterface;

/**
 * Class RepositoryRegistry
 *
 * @package RM\Component\Client
 * @author  h1karo <h1karo@outlook.com>
 */
class RepositoryRegistry implements RepositoryRegistryInterface
{
    private RepositoryFactoryInterface $factory;
    /**
     * @var Collection<string, RepositoryInterface>
     */
    private Collection $repositories;

    public function __construct(RepositoryFactoryInterface $factory)
    {
        $this->factory = $factory;
        $this->repositories = new ArrayCollection();
    }

    /**
     * @inheritDoc
     */
    public function getRepository(string $entity): RepositoryInterface
    {
        if ($this->repositories->containsKey($entity)) {
            return $this->repositories->get($entity);
        }

        $repository = $this->factory->build($entity);
        $this->repositories->set($entity, $repository);
        return $repository;
    }
}
