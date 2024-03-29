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

namespace RM\Component\Client;

use Psr\EventDispatcher\EventDispatcherInterface;
use RM\Component\Client\Event\HydratedEvent;
use RM\Component\Client\Event\SentEvent;
use RM\Component\Client\EventListener\LazyLoadListener;
use RM\Component\Client\EventListener\ThrowableSendListener;
use RM\Component\Client\Transport\TransportInterface;

/**
 * @author Oleg Kozlov <h1karo@remessage.ru>
 */
abstract class AbstractClientConfigurator
{
    private TransportInterface $transport;
    private EventDispatcherInterface $eventDispatcher;

    private bool $throwable = true;
    private bool $lazyLoad = true;

    public function __construct(TransportInterface $transport)
    {
        $this->transport = $transport;
    }

    public static function create(TransportInterface $transport): static
    {
        return new static($transport);
    }

    public function setThrowable(bool $throwable): static
    {
        $this->throwable = $throwable;

        return $this;
    }

    public function setLazyLoad(bool $lazyLoad): static
    {
        $this->lazyLoad = $lazyLoad;

        return $this;
    }

    public function getEventDispatcher(): EventDispatcherInterface
    {
        return $this->eventDispatcher;
    }

    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher): static
    {
        $this->eventDispatcher = $eventDispatcher;

        return $this;
    }

    public function build(): ClientInterface
    {
        $eventDispatcher = $this->getEventDispatcher();

        $client = ClientFactory::create($this->transport)
            ->setEventDispatcher($eventDispatcher)
            ->build()
        ;

        if ($this->throwable) {
            $this->registerListener(SentEvent::class, new ThrowableSendListener($eventDispatcher));
        }

        if ($this->lazyLoad) {
            $this->registerListener(HydratedEvent::class, new LazyLoadListener($client));
        }

        return $client;
    }

    abstract protected function registerListener(string $event, callable $listener): void;
}
