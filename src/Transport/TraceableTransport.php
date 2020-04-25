<?php

namespace RM\Component\Client\Transport;

use Psr\Log\LoggerInterface;
use RM\Component\Client\Auth\TokenStorageInterface;
use RM\Standard\Message\MessageInterface;
use Symfony\Contracts\Service\ResetInterface;

/**
 * Class TraceableTransport decorates to log and analysis message sending.
 *
 * @package RM\Component\Client\Transport
 * @author  h1karo <h1karo@outlook.com>
 */
class TraceableTransport implements TransportInterface, ResetInterface
{
    private TransportInterface $transport;
    private LoggerInterface $logger;

    /**
     * @var array<MessageInterface>[]
     */
    private iterable $interactions = [];

    public function __construct(TransportInterface $transport, LoggerInterface $logger)
    {
        $this->transport = $transport;
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     */
    public function send(MessageInterface $sent): MessageInterface
    {
        $received = $this->transport->send($sent);

        $message = sprintf('%s sent message to core.', static::class);
        $this->logger->debug($message, ['sent' => $sent->toArray(), 'received' => $received->toArray()]);
        $this->interactions[] = [$sent, $received];

        return $received;
    }

    /**
     * @inheritDoc
     */
    public function getTokenStorage(): TokenStorageInterface
    {
        return $this->transport->getTokenStorage();
    }

    public function reset(): void
    {
        $this->interactions = [];
    }
}
