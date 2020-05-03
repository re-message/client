<?php

namespace RM\Component\Client\Transport;

use RM\Standard\Message\MessageInterface;

/**
 * Class DecoratedTransport
 *
 * @package RM\Component\Client\Transport
 * @author  h1karo <h1karo@outlook.com>
 */
abstract class DecoratedTransport implements TransportInterface
{
    private TransportInterface $transport;

    public function __construct(TransportInterface $transport)
    {
        $this->transport = $transport;
    }

    /**
     * @inheritDoc
     */
    public function send(MessageInterface $message): MessageInterface
    {
        return $this->transport->send($message);
    }

    public function getRealTransport(): TransportInterface
    {
        $transport = $this->transport;
        while ($transport instanceof self) {
            $transport = $transport->getRealTransport();
        }
        return $transport;
    }
}
