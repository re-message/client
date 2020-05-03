<?php

namespace RM\Component\Client\Transport;

use RM\Component\Client\Security\Resolver\TokenResolverInterface;
use RM\Standard\Message\Serializer\MessageSerializerInterface;

/**
 * Class AbstractTransport
 *
 * @package RM\Component\Client\Transport
 * @author  h1karo <h1karo@outlook.com>
 */
abstract class AbstractTransport implements TransportInterface
{
    protected MessageSerializerInterface $serializer;
    protected TokenResolverInterface $tokenResolver;

    public function __construct(MessageSerializerInterface $serializer, TokenResolverInterface $tokenResolver)
    {
        $this->serializer = $serializer;
        $this->tokenResolver = $tokenResolver;
    }
}
