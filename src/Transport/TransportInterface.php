<?php

namespace RM\Component\Client\Transport;

use RM\Component\Client\Security\Resolver\AuthorizationResolverInterface;
use RM\Standard\Message\MessageInterface;

/**
 * Interface TransportInterface
 *
 * @package RM\Component\Client\Transport
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
interface TransportInterface
{
    public const DOMAIN = 'apis.relmsg.ru';
    public const VERSION = '1.0';

    /**
     * Sends the message into server and receive a response message.
     *
     * @param MessageInterface $message
     *
     * @return MessageInterface
     */
    public function send(MessageInterface $message): MessageInterface;

    /**
     * Configures resolver for transport to use authorization in requests.
     *
     * @param AuthorizationResolverInterface $resolver
     *
     * @return self
     */
    public function setResolver(AuthorizationResolverInterface $resolver): self;
}
