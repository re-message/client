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

namespace RM\Component\Client\Security\Credentials;

/**
 * Class Token.
 *
 * @author Oleg Kozlov <h1karo@relmsg.ru>
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
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function getCredentials(): string
    {
        return $this->getToken();
    }

    /**
     * {@inheritdoc}
     */
    final public function __serialize(): array
    {
        return ['token' => $this->token, 'object_id' => $this->objectId];
    }

    /**
     * {@inheritdoc}
     */
    final public function __unserialize(array $data): void
    {
        ['token' => $this->token, 'object_id' => $this->objectId] = $data;
    }
}
