<?php

namespace RM\Component\Client\Security\Credentials;

/**
 * Class Token
 *
 * @package RM\Component\Client\Security\Credentials
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
class Token implements AuthorizationInterface
{
    private string $token;
    private string $objectId;

    public function __construct(string $token, string $objectId)
    {
        $this->token = $token;
        $this->objectId = $objectId;
    }

    /**
     * @inheritDoc
     */
    public function isCompleted(): bool
    {
        return true;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getObjectId(): string
    {
        return $this->objectId;
    }

    /**
     * @inheritDoc
     */
    public function getCredentials(): string
    {
        return $this->getToken();
    }

    /**
     * @inheritDoc
     */
    final public function serialize(): string
    {
        $payload = ['credentials' => $this->getCredentials()];
        return serialize($payload);
    }

    /**
     * @inheritDoc
     */
    final public function unserialize($serialized): void
    {
        if (!is_string($serialized)) {
            throw new InvalidArgumentException('Expects string, got ' . gettype($serialized));
        }

        $data = unserialize($serialized, ['allowed_classes' => false]);
        $credentials = $data['credentials'];
        $this->token = $credentials;
    }
}
