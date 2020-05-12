<?php

namespace RM\Component\Client\Security\Resolver;

use RM\Component\Client\Security\Storage\TokenStorageInterface;
use RM\Standard\Message\MessageInterface;

/**
 * Interface TokenResolverInterface
 *
 * @package RM\Component\Client\Security\Resolver
 * @author  Oleg Kozlov <h1karo@outlook.com>
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

    /**
     * Returns the token storage used by resolve to get the token.
     *
     * @return TokenStorageInterface
     */
    public function getTokenStorage(): TokenStorageInterface;
}
