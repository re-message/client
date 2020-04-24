<?php

namespace RM\Component\Client;

use InvalidArgumentException;
use RM\Component\Client\Auth\AuthenticatorInterface;
use RM\Component\Client\Auth\TokenStorageInterface;
use RM\Standard\Message\MessageInterface;

/**
 * Class Client
 *
 * @package RM\Component\Client
 * @author  h1karo <h1karo@outlook.com>
 */
class Client extends RepositoryRegistry implements ClientInterface
{
    private const AUTH_PROVIDERS = [];

    public function createAuthorization(string $type): AuthenticatorInterface
    {
        $provider = self::AUTH_PROVIDERS[$type] ?? null;
        if ($provider === null) {
            throw new InvalidArgumentException(sprintf('Authorization provider with name `%s` does not exist.', $type));
        }

        return $provider($this, $this->getTokenStorage());
    }

    public function send(MessageInterface $message): MessageInterface
    {
        return $this->transport->send($message);
    }

    public function getTokenStorage(): TokenStorageInterface
    {
        return $this->transport->getTokenStorage();
    }
}
