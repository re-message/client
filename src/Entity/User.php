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

namespace RM\Component\Client\Entity;

use DateTime;
use DateTimeInterface;
use RM\Component\Client\Annotation\Entity;
use RM\Component\Client\Repository\UserRepository;

/**
 * Class User
 *
 * @Entity(repositoryClass=UserRepository::class)
 *
 * @author  Oleg Kozlov <h1karo@relmsg.ru>
 */
class User implements CreatableFromArray, Identifiable
{
    private string $id;
    private ?string $phone;
    private string $firstName;
    private ?string $lastName;
    private bool $active = true;
    private ?DateTimeInterface $birthday;

    public function __construct(
        string $id,
        ?string $phone,
        string $firstName,
        ?string $lastName,
        ?DateTimeInterface $birthday
    ) {
        $this->id = $id;
        $this->phone = $phone;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->birthday = $birthday;
    }

    /**
     * @inheritDoc
     */
    final public function getId(): string
    {
        return $this->id;
    }

    final public function getPhone(): ?string
    {
        return $this->phone;
    }

    final public function getFirstName(): string
    {
        return $this->firstName;
    }

    final public function getLastName(): ?string
    {
        return $this->lastName;
    }

    final public function getFullName(): string
    {
        $pieces = [$this->getFirstName(), $this->getLastName()];
        return implode(' ', array_filter($pieces));
    }

    public function getInitials(): string
    {
        $words = [$this->getFirstName(), $this->getLastName()];
        $letters = array_map(fn (string $word) => mb_substr($word, 0, 1), array_filter($words));
        $two = array_slice($letters, 0, 2);
        return implode($two);
    }

    final public function __toString(): string
    {
        return $this->getFullName();
    }

    final public function isActive(): bool
    {
        return $this->active;
    }

    final public function getBirthday(): ?DateTimeInterface
    {
        return $this->birthday;
    }

    /**
     * @inheritDoc
     */
    final public static function createFromArray(array $array): self
    {
        $id = $array['id'];
        $phone = $array['phone'] ?? null;
        $firstName = $array['firstName'];
        $lastName = $array['lastName'] ?? null;
        $birthday = null;

        if (array_key_exists('birthday', $array)) {
            $birthday = DateTime::createFromFormat('U', $array['birthday']);
        }

        return new self($id, $phone, $firstName, $lastName, $birthday);
    }
}
