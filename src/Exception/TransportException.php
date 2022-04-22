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

namespace RM\Component\Client\Exception;

use RM\Component\Client\Transport\TransportInterface;
use RuntimeException;
use Throwable;

/**
 * Class TransportException decorates exception thrown from {@see TransportInterface::send}.
 *
 * @author Oleg Kozlov <h1karo@remessage.ru>
 */
class TransportException extends RuntimeException implements ExceptionInterface
{
    public function __construct(Throwable $previous)
    {
        parent::__construct($previous->getMessage(), 0, $previous);
    }
}
