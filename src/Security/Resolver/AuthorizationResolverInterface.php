<?php

namespace RM\Component\Client\Security\Resolver;

use RM\Component\Client\Security\Credentials\AuthorizationInterface;
use RM\Standard\Message\MessageInterface;

/**
 * Interface AuthorizationResolverInterface
 *
 * @package RM\Component\Client\Security\Resolver
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
interface AuthorizationResolverInterface
{
    /**
     * Returns the authorization object which resolved for this message.
     *
     * @param MessageInterface $message
     *
     * @return AuthorizationInterface|null
     */
    public function resolve(MessageInterface $message): ?AuthorizationInterface;
}
