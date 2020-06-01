<?php

namespace RM\Component\Client\Security\Credentials;

use InvalidArgumentException;
use RM\Standard\Jwt\Exception\InvalidTokenException;
use RM\Standard\Jwt\Serializer\SignatureCompactSerializer;
use RM\Standard\Jwt\Token\TokenInterface;

/**
 * Class TokenAuthorization
 *
 * @package RM\Component\Client\Security\Credentials
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
class TokenAuthorization implements AuthorizationInterface
{
    private TokenInterface $token;

    private SignatureCompactSerializer $serializer;

    public function __construct(TokenInterface $token)
    {
        $this->token = $token;
        $this->serializer = new SignatureCompactSerializer();
    }

    /**
     * @inheritDoc
     */
    public function isCompleted(): bool
    {
        return true;
    }

    public function getToken(): TokenInterface
    {
        return $this->token;
    }

    /**
     * @inheritDoc
     * @throws InvalidTokenException
     */
    public function getCredentials(): string
    {
        return $this->serializer->serialize($this->token);
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
     * @throws InvalidTokenException
     */
    final public function unserialize($serialized): void
    {
        if (!is_string($serialized)) {
            throw new InvalidArgumentException('Expects string, got ' . gettype($serialized));
        }

        $data = unserialize($serialized, ['allowed_classes' => false]);
        $credentials = $data['credentials'];
        $token = $this->serializer->deserialize($credentials);
        $this->token = $token;
    }
}
