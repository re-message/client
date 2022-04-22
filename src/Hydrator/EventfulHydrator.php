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

namespace RM\Component\Client\Hydrator;

use Psr\EventDispatcher\EventDispatcherInterface;
use RM\Component\Client\Entity\EntityInterface;
use RM\Component\Client\Event\HydratedEvent;

/**
 * @author Oleg Kozlov <h1karo@remessage.ru>
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
