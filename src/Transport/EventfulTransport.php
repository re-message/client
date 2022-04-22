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

namespace RM\Component\Client\Transport;

use Psr\EventDispatcher\EventDispatcherInterface;
use RM\Component\Client\Event\SentEvent;
use RM\Standard\Message\MessageInterface;

/**
 * Class EventfulTransport.
 *
 * @author Oleg Kozlov <h1karo@relmsg.ru>
 */
class EventfulTransport extends DecoratedTransport
{
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(TransportInterface $transport, EventDispatcherInterface $eventDispatcher)
    {
        parent::__construct($transport);

        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @inheritDoc
     */
    public function send(MessageInterface $sent): MessageInterface
    {
        $received = parent::send($sent);

        $event = new SentEvent($sent, $received);
        $this->eventDispatcher->dispatch($event);

        return $event->getReceived();
    }
}
