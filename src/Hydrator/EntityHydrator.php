<?php

namespace RM\Component\Client\Hydrator;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\Reader;
use ReflectionMethod;
use ReflectionObject;
use RM\Component\Client\Annotation\LazyLoad;
use RM\Component\Client\Entity\CreatableFromArray;
use RM\Component\Client\RepositoryRegistryInterface;

/**
 * Class EntityHydrator
 *
 * @package RM\Component\Client\Hydrator
 * @author  h1karo <h1karo@outlook.com>
 */
class EntityHydrator implements HydratorInterface
{
    private RepositoryRegistryInterface $registry;
    private Reader $reader;

    public function __construct(RepositoryRegistryInterface $registry, ?Reader $reader = null)
    {
        $this->registry = $registry;
        $this->reader = $reader ?? new AnnotationReader();
    }

    /**
     * @inheritDoc
     */
    public function hydrate(array $data, string $class): object
    {
        $entity = $this->createEntity($class, $data);
        return $this->lazyLoad($entity);
    }

    protected function createEntity(string $class, array $data): object
    {
        if (is_subclass_of($class, CreatableFromArray::class, true)) {
            return call_user_func([$class, 'createFromArray'], $data);
        }

        return new $class(...$data);
    }

    protected function lazyLoad(object $entity): object
    {
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

    /**
     * @inheritDoc
     */
    public function supports(array $data, string $class): bool
    {
        return class_exists($class);
    }
}
