<?php

namespace RM\Component\Client\Security\Credentials;

use InvalidArgumentException;

/**
 * Class Request
 *
 * @package RM\Component\Client\Security\Credentials
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
class Request implements AuthorizationInterface
{
    private string $id;
    private string $phone;

    public function __construct(string $id, string $phone)
    {
        $this->id = $id;
        $this->phone = $phone;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

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
    public function getCredentials(): string
    {
        return $this->getId();
    }

    /**
     * @inheritDoc
     */
    public function serialize(): string
    {
        $payload = ['id' => $this->id, 'phone' => $this->phone];
        return serialize($payload);
    }

    /**
     * @inheritDoc
     */
    public function unserialize($serialized): void
    {
        if (!is_string($serialized)) {
            throw new InvalidArgumentException('Expects string, got ' . gettype($serialized));
        }

        $data = unserialize($serialized, ['allowed_classes' => false]);
        ['id' => $this->id, 'phone' => $this->phone] = $data;
    }
}
