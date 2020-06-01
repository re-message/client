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
        return null;
    }

    /**
     * @inheritDoc
     */
    public function unserialize($serialized): void { }

    /**
     * @inheritDoc
     */
    public function getCredentials(): string
    {
        throw new BadMethodCallException(sprintf('Don\'t use %s method of %s.', __FUNCTION__, __CLASS__));
    }
}
