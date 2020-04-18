<?php

namespace RM\Component\Client\Auth;

use RM\Standard\Message\MessageInterface;

/**
 * Interface TokenStorageInterface
 *
 * @package RM\Component\Client\Auth
 * @author  h1karo <h1karo@outlook.com>
 */
interface TokenStorageInterface
{
    /**
     * Sets the token into storage by type.
     *
     * @param string $type
     * @param string $token
     */
    public function set(string $type, string $token): void;

    /**
     * Get the token by type.
     *
     * @param string $type
     *
     * @return string|null
     */
    public function get(string $type): ?string;

    /**
     * Returns the token which resolved for this message.
     *
     * @param MessageInterface $message
     *
     * @return string|null
     */
    public function resolve(MessageInterface $message): ?string;
}
