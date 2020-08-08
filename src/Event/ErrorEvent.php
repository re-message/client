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

/**
 * Class ErrorEvent.
 *
 * @author Oleg Kozlov <h1karo@relmsg.ru>
 */
class ErrorEvent extends SentEvent
{
    private bool $handled = false;

    public function isHandled(): bool
    {
        return $this->handled;
    }

    public function setHandled(bool $handled = true): ErrorEvent
    {
        $this->handled = $handled;

        return $this;
    }
}
