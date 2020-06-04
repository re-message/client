<?php

namespace RM\Component\Client\Security\Credentials;

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
    public function __serialize(): array
    {
        return ['id' => $this->id, 'phone' => $this->phone];
    }

    /**
     * @inheritDoc
     */
    public function __unserialize(array $data): void
    {
        ['id' => $this->id, 'phone' => $this->phone] = $data;
    }
}
