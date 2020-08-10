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

use Psr\EventDispatcher\EventDispatcherInterface;
use RM\Component\Client\Event\ErrorEvent;
use RM\Component\Client\Event\SentEvent;
use RM\Component\Client\Exception\ErrorException;
use RM\Component\Client\Exception\UnexpectedMessageException;
use RM\Standard\Message\Error;
use RM\Standard\Message\Response;

/**
 * Class ThrowableSendListener.
 *
 * @author Oleg Kozlov <h1karo@relmsg.ru>
 */
class ThrowableSendListener
{
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param SentEvent $event
     *
     * @throws ErrorException
     */
    public function __invoke(SentEvent $event): void
    {
        $message = $event->getReceived();

        if ($message instanceof Error) {
            $errorEvent = new ErrorEvent($event->getSent(), $message);
            $this->eventDispatcher->dispatch($event);

            if ($errorEvent->isHandled()) {
                $event->setReceived($errorEvent->getReceived());

                return;
            }

            throw new ErrorException($message);
        }

        if (!$message instanceof Response) {
            throw new UnexpectedMessageException($message, Response::class);
        }
    }
}
