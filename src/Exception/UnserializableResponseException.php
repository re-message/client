<?php

namespace RM\Component\Client\Exception;

use Psr\Http\Message\ResponseInterface;
use RM\Standard\Message\MessageInterface;
use RuntimeException;
use Throwable;

/**
 * Class UnserializableResponseException throws when the serializer cannot deserialize a body of the received response
 * into {@see MessageInterface}
 *
 * @package RM\Component\Client\Exception
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
class UnserializableResponseException extends RuntimeException implements ExceptionInterface
{
    use ResponsableExceptionTrait;

    public function __construct(ResponseInterface $reason, Throwable $previous = null)
    {
        parent::__construct('The received body cannot be serialized.', 0, $previous);
        $this->reason = $reason;
    }
}
