<?php

namespace RM\Component\Client;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;
use RM\Component\Client\Annotation\Entity;
use RM\Component\Client\Hydrator\EntityHydrator;
use RM\Component\Client\Hydrator\HydratorInterface;
use RM\Component\Client\Repository\RepositoryInterface;
use RM\Component\Client\Transport\TransportInterface;

/**
 * Class RepositoryRegistry
 *
 * @package RM\Component\Client
 * @author  h1karo <h1karo@outlook.com>
 */
class RepositoryRegistry implements RepositoryRegistryInterface
{
    protected TransportInterface $transport;
    protected HydratorInterface $hydrator;

    private Reader $reader;
    /**
     * @var Collection<string, RepositoryInterface>
     */
    private Collection $repositories;

    public function __construct(
        TransportInterface $transport,
        ?HydratorInterface $hydrator = null,
        ?Reader $reader = null
    ) {
        $this->transport = $transport;
        $this->hydrator = $hydrator ?? new EntityHydrator($this);
        $this->reader = $reader ?? new AnnotationReader();
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

        if (!class_exists($entity)) {
            throw new InvalidArgumentException('Passed entity class does not exist.');
        }

        try {
            $reflect = new ReflectionClass($entity);
            $annotation = $this->reader->getClassAnnotation($reflect, Entity::class);
            if (!$annotation instanceof Entity) {
                throw new InvalidArgumentException('Passed class is not entity.');
            }

            $repositoryClass = $annotation->repositoryClass;
            if ($repositoryClass === null) {
                $r = new ReflectionClass(RepositoryInterface::class);
                $repositoryClass = sprintf("%s\\%sRepository", $r->getNamespaceName(), $reflect->getShortName());
            }

            $repository = new $repositoryClass($this->transport, $this->hydrator);
            $this->repositories->set($entity, $repository);
            return $repository;
        } catch (ReflectionException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }
}
