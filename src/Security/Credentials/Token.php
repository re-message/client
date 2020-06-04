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
    final public function __serialize(): array
    {
        return ['token' => $this->token, 'object_id' => $this->objectId];
    }

    /**
     * @inheritDoc
     */
    final public function __unserialize(array $data): void
    {
        ['token' => $this->token, 'object_id' => $this->objectId] = $data;
    }
}
