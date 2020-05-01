<?php

namespace RM\Component\Client\Exception;

use RuntimeException;

/**
 * Class FactoryException
 *
 * @package RM\Component\Client\Exception
 * @author  h1karo <h1karo@outlook.com>
 */
class FactoryException extends RuntimeException implements ExceptionInterface
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
