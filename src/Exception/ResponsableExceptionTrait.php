<?php

namespace RM\Component\Client\Exception;

use Psr\Http\Message\ResponseInterface;

/**
 * Trait ResponsableExceptionTrait
 *
 * @package RM\Component\Client\Exception
 * @author  Oleg Kozlov <h1karo@outlook.com>
 * @internal
 */
trait ResponsableExceptionTrait
{
    private ResponseInterface $reason;

    public function getReason(): ResponseInterface
    {
        return $this->reason;
    }
}
