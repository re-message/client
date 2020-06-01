<?php

namespace RM\Component\Client\Security\Credentials;

/**
 * Class NullAuthorization
 *
 * @package RM\Component\Client\Security\Credentials
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
final class NullAuthorization implements AuthorizationInterface
{
    /**
     * @inheritDoc
     */
    public function isCompleted(): bool
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function serialize()
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function unserialize($serialized): void { }
}
