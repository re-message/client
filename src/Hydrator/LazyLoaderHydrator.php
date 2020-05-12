<?php

namespace RM\Component\Client\Hydrator;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\Reader;
use InvalidArgumentException;
use ReflectionMethod;
use ReflectionObject;
use RM\Component\Client\Annotation\LazyLoad;
use RM\Component\Client\Repository\RepositoryRegistryInterface;

/**
 * Class LazyLoaderHydrator
 *
 * @package RM\Component\Client\Hydrator
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
class LazyLoaderHydrator extends DecoratedHydrator
{
    private RepositoryRegistryInterface $registry;
    private Reader $reader;

    public function __construct(EntityHydrator $hydrator, RepositoryRegistryInterface $registry, ?Reader $reader = null)
    {
        parent::__construct($hydrator);
        $this->registry = $registry;
        $this->reader = $reader ?? new AnnotationReader();
    }

    public function hydrate(array $data, string $class): object
    {
        $entity = parent::hydrate($data, $class);

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
