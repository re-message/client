<?php
/*
 * This file is a part of Relations Messenger Client.
 * This package is a part of Relations Messenger.
 *
 * @link      https://github.com/relmsg/client
 * @link      https://dev.relmsg.ru/packages/client
 * @copyright Copyright (c) 2018-2020 Relations Messenger
 * @author    Oleg Kozlov <h1karo@outlook.com>
 * @license   https://legal.relmsg.ru/licenses/client
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RM\Component\Client\Repository\Factory;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\Reader;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;
use RM\Component\Client\Annotation\Entity;
use RM\Component\Client\Repository\RepositoryInterface;

/**
 * Class AbstractFactory
 *
 * @author  Oleg Kozlov <h1karo@outlook.com>
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
