<?php

namespace RM\Component\Client\Config;

use LogicException;

/**
 * Class ActionConfig
 *
 * @package RM\Component\Client\Config
 * @author  h1karo <h1karo@outlook.com>
 */
class ActionConfig
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
            $message = sprintf('Please check the %s::isAuthorizationRequired() method before use this.', __CLASS__);
            throw new LogicException($message);
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
