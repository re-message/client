<?php

namespace RM\Component\Client\Repository;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\Reader;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;
use RM\Component\Client\Annotation\Entity;

/**
 * Class AbstractFactory
 *
 * @package RM\Component\Client\Repository
 * @author  h1karo <h1karo@outlook.com>
 */
abstract class AbstractFactory implements RepositoryFactoryInterface
{
    private Reader $reader;

    public function __construct(?Reader $reader = null)
    {
        $this->reader = $reader ?? new AnnotationReader();
    }

    protected function getRepositoryClass(string $entity): string
    {
        if (!class_exists($entity)) {
            throw new InvalidArgumentException('Passed entity class does not exist.');
        }

        try {
            $reflect = new ReflectionClass($entity);
            $annotation = $this->readEntityAnnotation($reflect);
            if ($annotation->repositoryClass !== null) {
                return $annotation->repositoryClass;
            }

            return $this->buildRepositoryClass($reflect);
        } catch (ReflectionException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }

    protected function readEntityAnnotation(ReflectionClass $entity): Entity
    {
        $annotation = $this->reader->getClassAnnotation($entity, Entity::class);
        if (!$annotation instanceof Entity) {
            throw new InvalidArgumentException('Passed class is not entity.');
        }

        return $annotation;
    }

    protected function buildRepositoryClass(ReflectionClass $entity): string
    {
        $reflect = new ReflectionClass(RepositoryInterface::class);
        return sprintf("%s\\%sRepository", $reflect->getNamespaceName(), $entity->getShortName());
    }
}
