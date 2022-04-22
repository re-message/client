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

namespace RM\Component\Client\Event;

use RM\Standard\Message\MessageInterface;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * @author Oleg Kozlov <h1karo@remessage.ru>
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
