<?php

namespace RM\Component\Client\Exception;

use Psr\Http\Message\ResponseInterface;
use RuntimeException;
use Throwable;

/**
 * Class UnexpectedResponseException
 *
 * @package RM\Component\Client\Exception
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
class UnexpectedResponseException extends RuntimeException implements ExceptionInterface
{
    use ResponsableExceptionTrait;

    public function __construct(ResponseInterface $reason, Throwable $previous = null)
    {
        parent::__construct('The received response is invalid.', 0, $previous);
        $this->reason = $reason;
    }
}
