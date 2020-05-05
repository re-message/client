<?php

namespace RM\Component\Client\Hydrator\Handler;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\Reader;
use InvalidArgumentException;
use ReflectionMethod;
use ReflectionObject;
use RM\Component\Client\Annotation\LazyLoad;
use RM\Component\Client\Hydrator\EntityHydrator;
use RM\Component\Client\Hydrator\HydratorInterface;
use RM\Component\Client\RepositoryRegistryInterface;

/**
 * Class LazyLoader
 *
 * @package RM\Component\Client\Hydrator\Handler
 * @author  h1karo <h1karo@outlook.com>
 */
class LazyLoader implements HydratorHandlerInterface
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
    public function handle($entity): object
    {
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

    /**
     * @inheritDoc
     */
    public function supports(HydratorInterface $hydrator, $entity): bool
    {
        return $hydrator instanceof EntityHydrator && is_object($entity);
    }
}
