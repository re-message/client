<?php
/*
 * This file is a part of Re Message Client.
 * This package is a part of Re Message.
 *
 * @link      https://github.com/re-message/client
 * @link      https://dev.remessage.ru/packages/client
 * @copyright Copyright (c) 2018-2022 Re Message
 * @author    Oleg Kozlov <h1karo@remessage.ru>
 * @license   Apache License 2.0
 * @license   https://legal.remessage.ru/licenses/client
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
 * @author Oleg Kozlov <h1karo@remessage.ru>
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
