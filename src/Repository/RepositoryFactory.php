<?php

namespace RM\Component\Client\Repository;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\Reader;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;
use RM\Component\Client\Annotation\Entity;
use RM\Component\Client\Hydrator\HydratorInterface;
use RM\Component\Client\Transport\TransportInterface;

/**
 * Class RepositoryFactory
 *
 * @package RM\Component\Client\Repository
 * @author  h1karo <h1karo@outlook.com>
 */
class RepositoryFactory implements RepositoryFactoryInterface
{
    private TransportInterface $transport;
    private HydratorInterface $hydrator;
    private Reader $reader;

    public function __construct(
        TransportInterface $transport,
        HydratorInterface $hydrator,
        ?Reader $reader = null
    ) {
        $this->transport = $transport;
        $this->hydrator = $hydrator;
        $this->reader = $reader ?? new AnnotationReader();
    }

    /**
     * @inheritDoc
     */
    public function build(string $entity): RepositoryInterface
    {
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

            return new $repositoryClass($this->transport, $this->hydrator);
        } catch (ReflectionException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }
}
