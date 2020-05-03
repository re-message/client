<?php

namespace RM\Component\Client\Security\Resolver;

use RM\Standard\Message\MessageInterface;

/**
 * Interface TokenResolverInterface
 *
 * @package RM\Component\Client\Security\Resolver
 * @author  h1karo <h1karo@outlook.com>
 */
interface TokenResolverInterface
{
    /**
     * Returns the token which resolved for this message.
     *
     * @param MessageInterface $message
     *
     * @return string|null
     */
    public function resolve(MessageInterface $message): ?string;
}
