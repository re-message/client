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
 * Class Request.
 *
 * @author Oleg Kozlov <h1karo@remessage.ru>
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
