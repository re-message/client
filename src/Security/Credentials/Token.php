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

namespace RM\Component\Client\Security\Credentials;

/**
 * Class Token.
 *
 * @author Oleg Kozlov <h1karo@remessage.ru>
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
