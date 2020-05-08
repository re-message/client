<?php

namespace RM\Component\Client\Transport;

use RM\Component\Client\Security\Resolver\TokenResolverInterface;
use RM\Component\Client\Security\Storage\TokenStorageInterface;
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
    protected TokenResolverInterface $resolver;

    public function __construct(MessageSerializerInterface $serializer, TokenResolverInterface $tokenResolver)
    {
        $this->serializer = $serializer;
        $this->resolver = $tokenResolver;
    }

    /**
     * @inheritDoc
     */
    public function getTokenStorage(): TokenStorageInterface
    {
        return $this->resolver->getTokenStorage();
    }
}
