<?php

namespace RM\Component\Client\Hydrator;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\Reader;
use InvalidArgumentException;
use ReflectionMethod;
use ReflectionObject;
use RM\Component\Client\Annotation\LazyLoad;
use RM\Component\Client\Repository\Registry\RepositoryRegistryInterface;

/**
 * Class LazyLoaderHydrator
 *
 * @package RM\Component\Client\Hydrator
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
class LazyLoaderHydrator extends DecoratedHydrator
{
    private Reader $reader;
    private ?RepositoryRegistryInterface $registry = null;

    public function __construct(EntityHydrator $hydrator, ?Reader $reader = null)
    {
        parent::__construct($hydrator);
        $this->reader = $reader ?? new AnnotationReader();
    }

    public function setRepositoryRegistry(RepositoryRegistryInterface $registry): self
    {
        $this->registry = $registry;
        return $this;
    }

    public function hydrate(array $data, string $class): object
    {
        $entity = parent::hydrate($data, $class);

        if ($this->registry === null) {
            return $entity;
        }

        if (!is_object($entity)) {
            throw new InvalidArgumentException('Expects an object.');
        }

        $reflect = new ReflectionObject($entity);
        foreach ($reflect->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            $annotation = $this->reader->getMethodAnnotation($method, LazyLoad::class);
            if (!$annotation instanceof LazyLoad) {
                continue;
            }

            $repo = $this->registry->getRepository($annotation->entity);
            $method->invoke($entity, fn($id) => $repo->get($id));
        }

        return $entity;
    }
}
