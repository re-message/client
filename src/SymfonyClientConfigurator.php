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

use InvalidArgumentException;
use RM\Component\Client\Transport\TransportInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use UnexpectedValueException;

/**
 * @author Oleg Kozlov <h1karo@remessage.ru>
 */
class SymfonyClientConfigurator extends AbstractClientConfigurator
{
    public function __construct(TransportInterface $transport)
    {
        parent::__construct($transport);

        if (!class_exists(EventDispatcher::class)) {
            $message = sprintf(
                'To use %s you need to install the symfony/event-dispatcher package.',
                self::class
            );

            throw new InvalidArgumentException($message);
        }

        $this->setEventDispatcher(new EventDispatcher());
    }

    protected function registerListener(string $event, callable $listener): void
    {
        $eventDispatcher = $this->getEventDispatcher();

        if (!$eventDispatcher instanceof EventDispatcherInterface) {
            throw new UnexpectedValueException(
                sprintf(
                    'Expected instance of %s, got %s.',
                    EventDispatcherInterface::class,
                    get_class($eventDispatcher)
                )
            );
        }

        $eventDispatcher->addListener($event, $listener);
    }
}
