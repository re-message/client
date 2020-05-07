<?php

namespace RM\Component\Client\Exception;

use RuntimeException;

/**
 * Class TokenNotFoundException
 *
 * @package RM\Component\Client\Exception
 * @author  h1karo <h1karo@outlook.com>
 */
class TokenNotFoundException extends RuntimeException implements ExceptionInterface
{
    public function __construct(string $type)
    {
        $message = sprintf('The access token with type %s does not exist.', $type);
        parent::__construct($message);
    }
}
