<?php
/*
 * This file is a part of Re Message Client.
 * This package is a part of Re Message.
 *
 * @link      https://github.com/re-message/client
 * @link      https://dev.remessage.ru/packages/client
 * @copyright Copyright (c) 2018-2022 Re Message
 * @author    Oleg Kozlov <h1karo@remessage.ru>
 * @license   Apache License 2.0
 * @license   https://legal.remessage.ru/licenses/client
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RM\Component\Client\Security\Config;

use BadMethodCallException;

/**
 * @author Oleg Kozlov <h1karo@remessage.ru>
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
        return null !== $this->authorizations;
    }

    public function getAuthorizations(): array
    {
        if (null === $this->authorizations) {
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

    public static function createFromArray(array $config): static
    {
        return new static($config['authorizations'] ?? null);
    }
}
