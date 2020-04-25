<?php

namespace RM\Component\Client\Exception;

use RM\Standard\Message\MessageInterface;

trait MessageExceptionTrait
{
    private MessageInterface $reason;

    public function getReason(): MessageInterface
    {
        return $this->reason;
    }
}
