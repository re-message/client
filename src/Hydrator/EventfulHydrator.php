<?php
/*
 * This file is a part of Relations Messenger Client.
 * This package is a part of Relations Messenger.
 *
 * @link      https://github.com/relmsg/client
 * @link      https://dev.relmsg.ru/packages/client
 * @copyright Copyright (c) 2018-2022 Relations Messenger
 * @author    Oleg Kozlov <h1karo@relmsg.ru>
 * @license   https://legal.relmsg.ru/licenses/client
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RM\Component\Client\Hydrator;

use Psr\EventDispatcher\EventDispatcherInterface;
use RM\Component\Client\Entity\EntityInterface;
use RM\Component\Client\Event\HydratedEvent;

/**
 * Class EventfulHydrator.
 *
 * @author Oleg Kozlov <h1karo@relmsg.ru>
 */
class EventfulHydrator extends DecoratedHydrator
{
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(HydratorInterface $hydrator, EventDispatcherInterface $eventDispatcher)
    {
        parent::__construct($hydrator);

        $this->eventDispatcher = $eventDispatcher;
    }

    public function hydrate(array $data, string $class): EntityInterface
    {
        $object = parent::hydrate($data, $class);

        $event = new HydratedEvent($object);
        $this->eventDispatcher->dispatch($event);

        return $event->getEntity();
    }
}
