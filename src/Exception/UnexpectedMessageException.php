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

namespace RM\Component\Client\Exception;

use RM\Standard\Message\MessageInterface;
use RuntimeException;
use Throwable;

/**
 * Class UnexpectedMessageException
 *
 * @author Oleg Kozlov <h1karo@relmsg.ru>
 */
class UnexpectedMessageException extends RuntimeException implements ExceptionInterface
{
    use MessageExceptionTrait;

    public function __construct(MessageInterface $reason, string $expects, Throwable $previous = null)
    {
        $message = sprintf('The received message is not valid, expects %d.', $expects);
        parent::__construct($message, 0, $previous);
        $this->reason = $reason;
    }
}
