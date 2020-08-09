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
 * Class Request.
 *
 * @author Oleg Kozlov <h1karo@relmsg.ru>
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
     * {@inheritdoc}
     */
    public function isCompleted(): bool
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getCredentials(): string
    {
        return $this->getId();
    }

    /**
     * {@inheritdoc}
     */
    public function __serialize(): array
    {
        return ['id' => $this->id, 'phone' => $this->phone];
    }

    /**
     * {@inheritdoc}
     */
    public function __unserialize(array $data): void
    {
        ['id' => $this->id, 'phone' => $this->phone] = $data;
    }
}
