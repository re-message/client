<?php
/*
 * This file is a part of Relations Messenger Client.
 * This package is a part of Relations Messenger.
 *
 * @link      https://github.com/relmsg/client
 * @link      https://dev.relmsg.ru/packages/client
 * @copyright Copyright (c) 2018-2020 Relations Messenger
 * @author    Oleg Kozlov <h1karo@relmsg.ru>
 * @license   https://legal.relmsg.ru/licenses/client
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RM\Component\Client\EventListener;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\Reader;
use ReflectionMethod;
use ReflectionObject;
use RM\Component\Client\Annotation\LazyLoad;
use RM\Component\Client\Event\HydratedEvent;
use RM\Component\Client\Repository\Registry\RepositoryRegistryInterface;

/**
 * Class LazyLoadListener.
 *
 * @author Oleg Kozlov <h1karo@relmsg.ru>
 */
class LazyLoadListener
{
    private RepositoryRegistryInterface $registry;
    private Reader $reader;

    public function __construct(RepositoryRegistryInterface $registry, ?Reader $reader = null)
    {
        $this->registry = $registry;
        $this->reader = $reader ?? new AnnotationReader();
    }

    public function __invoke(HydratedEvent $event): void
    {
        $entity = $event->getEntity();

        $reflect = new ReflectionObject($entity);
        foreach ($reflect->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            $annotation = $this->reader->getMethodAnnotation($method, LazyLoad::class);
            if (!$annotation instanceof LazyLoad) {
                continue;
            }

            $repo = $this->registry->getRepository($annotation->entity);
            $method->invoke($entity, fn ($id) => $repo->find($id));
        }
    }
}
