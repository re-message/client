<?php

namespace RM\Component\Client;

use RM\Component\Client\Transport\ThrowableTransport;
use RM\Component\Client\Transport\TransportInterface;

/**
 * Class ClientConfigurator
 *
 * @package RM\Component\Client
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
class ClientConfigurator
{
    private TransportInterface $transport;
    private bool $throwable = true;

    public function __construct(TransportInterface $transport)
    {
        $this->transport = $transport;
    }

    public static function create(TransportInterface $transport): self
    {
        return new static($transport);
    }

    public function setThrowable(bool $throwable): ClientConfigurator
    {
        $this->throwable = $throwable;
        return $this;
    }

    public function build(): ClientInterface
    {
        $transport = $this->transport;
        if ($this->throwable && !$transport instanceof ThrowableTransport) {
            $transport = new ThrowableTransport($transport);
        }

        return ClientFactory::create($transport)->build();
    }
}