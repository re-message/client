<?php

namespace RM\Component\Client\Transport;

use RM\Component\Client\Auth\TokenStorageInterface;
use RM\Component\Client\Exception\ErrorException;
use RM\Component\Client\Exception\UnexpectedMessageException;
use RM\Standard\Message\Error;
use RM\Standard\Message\MessageInterface;
use RM\Standard\Message\Response;

/**
 * Class ThrowableTransport decorates transport to throw exception on errors.
 *
 * @package RM\Component\Client\Transport
 * @author  h1karo <h1karo@outlook.com>
 */
class ThrowableTransport implements TransportInterface
{
    private TransportInterface $transport;

    public function __construct(TransportInterface $transport)
    {
        $this->transport = $transport;
    }

    /**
     * @inheritDoc
     * @throws ErrorException
     */
    public function send(MessageInterface $message): MessageInterface
    {
        $response = $this->transport->send($message);

        if ($response instanceof Error) {
            throw new ErrorException($response);
        }

        if (!$response instanceof Response) {
            throw new UnexpectedMessageException($response, Response::class);
        }

        return $response;
    }

    /**
     * @inheritDoc
     */
    public function getTokenStorage(): TokenStorageInterface
    {
        return $this->transport->getTokenStorage();
    }
}
