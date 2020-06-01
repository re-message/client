<?php

namespace RM\Component\Client\Transport;

use RM\Component\Client\Security\Resolver\AuthorizationResolverInterface;
use RM\Standard\Message\MessageInterface;

/**
 * Class DecoratedTransport
 *
 * @package RM\Component\Client\Transport
 * @author  Oleg Kozlov <h1karo@outlook.com>
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

    /**
     * @inheritDoc
     */
    public function setResolver(AuthorizationResolverInterface $resolver): self
    {
        $this->transport->setResolver($resolver);

        return $this;
    }

    public function getTransport(): TransportInterface
    {
        $transport = $this->transport;

        while ($transport instanceof self) {
            $transport = $transport->getTransport();
        }

        return $transport;
    }
}
