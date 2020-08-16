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

namespace RM\Component\Client;

use Psr\EventDispatcher\EventDispatcherInterface;
use RM\Component\Client\Event\SentEvent;
use RM\Component\Client\EventListener\ThrowableSendListener;
use RM\Component\Client\Transport\TransportInterface;

/**
 * Class AbstractClientConfigurator.
 *
 * @author Oleg Kozlov <h1karo@relmsg.ru>
 */
abstract class AbstractClientConfigurator
{
    private TransportInterface $transport;
    private EventDispatcherInterface $eventDispatcher;

    private bool $throwable = true;

    public function __construct(TransportInterface $transport)
    {
        $this->transport = $transport;
    }

    public static function create(TransportInterface $transport): self
    {
        return new static($transport);
    }

    public function setThrowable(bool $throwable): AbstractClientConfigurator
    {
        $this->throwable = $throwable;

        return $this;
    }

    public function getEventDispatcher(): EventDispatcherInterface
    {
        return $this->eventDispatcher;
    }

    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher): self
    {
        $this->eventDispatcher = $eventDispatcher;

        return $this;
    }

    public function build(): ClientInterface
    {
        $eventDispatcher = $this->getEventDispatcher();

        $factory = ClientFactory::create($this->transport)
            ->setEventDispatcher($eventDispatcher)
        ;

        if ($this->throwable) {
            $this->registerListener(SentEvent::class, new ThrowableSendListener($eventDispatcher));
        }

        return $factory->build();
    }

    abstract protected function registerListener(string $event, callable $listener): void;
}
