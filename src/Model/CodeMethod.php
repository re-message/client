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

namespace RM\Component\Client\Model;

use JsonSerializable;

/**
 * @author Oleg Kozlov <h1karo@remessage.ru>
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
