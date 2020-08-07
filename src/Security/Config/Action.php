<?php
/*
 * This file is a part of Relations Messenger Client.
 * This package is a part of Relations Messenger.
 *
 * @link      https://github.com/relmsg/client
 * @link      https://dev.relmsg.ru/packages/client
 * @copyright Copyright (c) 2018-2020 Relations Messenger
 * @author    Oleg Kozlov <h1karo@relmsg.ru>
 * @license   https://legal.relmsg.ru/licenses/client
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RM\Component\Client\Security\Config;

use BadMethodCallException;

/**
 * Class Action
 *
 * @author Oleg Kozlov <h1karo@relmsg.ru>
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
        return $this->authorizations !== null;
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
