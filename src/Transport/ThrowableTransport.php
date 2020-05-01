<?php

namespace RM\Component\Client\Transport;

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
class ThrowableTransport extends DecoratedTransport
{
    /**
     * @inheritDoc
     * @throws ErrorException
     */
    public function send(MessageInterface $message): MessageInterface
    {
        $response = parent::send($message);

        if ($response instanceof Error) {
            throw new ErrorException($response);
        }

        if (!$response instanceof Response) {
            throw new UnexpectedMessageException($response, Response::class);
        }

        return $response;
    }
}
