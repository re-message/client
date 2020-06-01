<?php

namespace RM\Component\Client\Transport;

use RM\Component\Client\Security\Resolver\AuthorizationResolverInterface;
use RM\Standard\Message\Serializer\MessageSerializerInterface;

/**
 * Class AbstractTransport
 *
 * @package RM\Component\Client\Transport
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
abstract class AbstractTransport implements TransportInterface
{
    protected MessageSerializerInterface $serializer;
    protected ?AuthorizationResolverInterface $resolver = null;

    public function __construct(MessageSerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @inheritDoc
     */
    public function setResolver(AuthorizationResolverInterface $resolver): self
    {
        $this->resolver = $resolver;

        return $this;
    }
}
