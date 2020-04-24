<?php

namespace RM\Component\Client\Exception;

use RM\Component\Client\Transport\TransportInterface;
use RM\Standard\Message\MessageInterface;
use RuntimeException;
use Throwable;

/**
 * Class UnserializableMessageException throws when the message passed into {@see TransportInterface::send} cannot be
 * serialized into safe-transfer format.
 *
 * @package RM\Component\Client\Exception
 * @author  h1karo <h1karo@outlook.com>
 */
class UnserializableMessageException extends RuntimeException implements ExceptionInterface
{
    private MessageInterface $reason;

    public function __construct(MessageInterface $reason, Throwable $previous = null)
    {
        parent::__construct('The received body cannot be serialized.', 0, $previous);
        $this->reason = $reason;
    }

    public function getReason(): MessageInterface
    {
        return $this->reason;
    }
}
