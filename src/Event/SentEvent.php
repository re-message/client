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

namespace RM\Component\Client\Event;

use RM\Standard\Message\MessageInterface;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class SentEvent.
 *
 * @author Oleg Kozlov <h1karo@relmsg.ru>
 */
class SentEvent extends Event
{
    private MessageInterface $sent;
    private MessageInterface $received;

    public function __construct(MessageInterface $sent, MessageInterface $received)
    {
        $this->sent = $sent;
        $this->received = $received;
    }

    public function getSent(): MessageInterface
    {
        return $this->sent;
    }

    public function getReceived(): MessageInterface
    {
        return $this->received;
    }

    public function setReceived(MessageInterface $received): SentEvent
    {
        $this->received = $received;

        return $this;
    }
}
