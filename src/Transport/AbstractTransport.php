<?php

namespace RM\Component\Client\Transport;

use RM\Component\Client\Security\Storage\TokenStorage;
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
    protected TokenStorageInterface $tokenStorage;

    public function __construct(MessageSerializerInterface $serializer, ?TokenStorageInterface $tokenStorage = null)
    {
        $this->serializer = $serializer;
        $this->tokenStorage = $tokenStorage ?? new TokenStorage();
    }

    public function getTokenStorage(): TokenStorageInterface
    {
        return $this->tokenStorage;
    }
}
