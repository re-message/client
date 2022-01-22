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

namespace RM\Component\Client\Model;

use JsonSerializable;

/**
 * Enum CodeMethod.
 *
 * @author Oleg Kozlov <h1karo@relmsg.ru>
 */
enum CodeMethod: string implements JsonSerializable
{
    case AUTO = 'auto';
    case NOTIFICATION = 'notification';
    case SMS = 'sms';

    public function jsonSerialize(): string
    {
        return $this->value;
    }
}
