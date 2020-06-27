<?php

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
 * @package RM\Component\Client\Entity
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
class User implements CreatableFromArray, Identifiable
{
    private string $id;
    private ?string $phone;
    private string $firstName;
    private ?string $lastName;
    private bool $active = true;
    private DateTimeInterface $birthday;

    public function __construct(
        string $id,
        ?string $phone,
        string $firstName,
        ?string $lastName,
        DateTimeInterface $birthday
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
    public function getId(): string
    {
        return $this->id;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getFullName(): string
    {
        $pieces = [$this->getFirstName(), $this->getLastName()];
        return implode(' ', array_filter($pieces));
    }

    public function getInitials(): string
    {
        $words = [$this->getFirstName(), $this->getLastName()];
        $letters = array_map(fn (string $word) => mb_substr($word, 0, 1), $words);
        $two = array_slice($letters, 0, 2);
        return implode($two);
    }

    public function __toString(): string
    {
        return $this->getFullName();
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function getBirthday(): DateTimeInterface
    {
        return $this->birthday;
    }

    /**
     * @inheritDoc
     */
    public static function createFromArray(array $array): self
    {
        $id = $array['id'];
        $phone = $array['phone'] ?? null;
        $firstName = $array['firstName'];
        $lastName = $array['lastName'] ?? null;
        $birthday = DateTime::createFromFormat('U', $array['birthday']);
        return new self($id, $phone, $firstName, $lastName, $birthday);
    }
}
