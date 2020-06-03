<?php

namespace RM\Component\Client\Security\Config;

use BadMethodCallException;

/**
 * Class Action
 *
 * @package RM\Component\Client\Security\Config
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
class Action
{
    private ?array $authorizations;

    public function __construct(?array $authorizations)
    {
        $this->authorizations = $authorizations;
    }

    public function isAuthorizationRequired(): bool
    {
        return $this->authorizations === null;
    }

    public function getAuthorizations(): array
    {
        if ($this->authorizations === null) {
            $method = 'isAuthorizationRequired';
            $message = sprintf('Please check the %s::%s() method before use this.', __CLASS__, $method);
            throw new BadMethodCallException($message);
        }

        return $this->authorizations;
    }

    public function supportsAuthorization(string $type): bool
    {
        return in_array($type, $this->getAuthorizations(), true);
    }

    public static function createFromArray(array $config): self
    {
        return new self($config['authorizations'] ?? null);
    }
}
