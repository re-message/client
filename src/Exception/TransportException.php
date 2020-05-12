<?php

namespace RM\Component\Client\Exception;

use RM\Component\Client\Transport\TransportInterface;
use RuntimeException;
use Throwable;

/**
 * Class TransportException decorates exception thrown from {@see TransportInterface::send}.
 *
 * @package RM\Component\Client\Exception
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
class TransportException extends RuntimeException implements ExceptionInterface
{
    public function __construct(Throwable $previous)
    {
        parent::__construct($previous->getMessage(), $previous);
    }
}
