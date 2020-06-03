<?php

namespace RM\Component\Client\Security\Credentials;

use BadMethodCallException;

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
        throw new BadMethodCallException(sprintf('%s can not be serialized.', self::class));
    }

    /**
     * @inheritDoc
     */
    public function unserialize($serialized): void
    {
        throw new BadMethodCallException(sprintf('%s can not be unserialized.', self::class));
    }

    /**
     * @inheritDoc
     */
    public function getCredentials(): string
    {
        throw new BadMethodCallException(sprintf('Do not use %s method of %s.', __FUNCTION__, self::class));
    }
}
