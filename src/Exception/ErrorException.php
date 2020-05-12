<?php

namespace RM\Component\Client\Exception;

use Exception;
use RM\Standard\Message\Error;

/**
 * Class ErrorException
 *
 * @package RM\Component\Client\Exception
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
class ErrorException extends Exception implements ExceptionInterface
{
    private Error $error;

    public function __construct(Error $error)
    {
        parent::__construct('The error message received.');
        $this->error = $error;
    }

    public function getError(): Error
    {
        return $this->error;
    }
}
