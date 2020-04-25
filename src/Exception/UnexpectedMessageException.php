<?php

namespace RM\Component\Client\Exception;

use RM\Standard\Message\MessageInterface;
use RuntimeException;
use Throwable;

/**
 * Class UnexpectedMessageException
 *
 * @package RM\Component\Client\Exception
 * @author  h1karo <h1karo@outlook.com>
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
