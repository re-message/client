<?php
/*
 * This file is a part of Relations Messenger Client.
 * This package is a part of Relations Messenger.
 *
 * @link      https://github.com/relmsg/client
 * @link      https://dev.relmsg.ru/packages/client
 * @copyright Copyright (c) 2018-2020 Relations Messenger
 * @author    Oleg Kozlov <h1karo@outlook.com>
 * @license   https://legal.relmsg.ru/licenses/client
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RM\Component\Client\Entity;

use Closure;
use RM\Component\Client\Annotation\Entity;
use RM\Component\Client\Annotation\LazyLoad;
use RM\Component\Client\Repository\ApplicationRepository;

/**
 * Class Application
 *
 * @Entity(repositoryClass=ApplicationRepository::class)
 *
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
class Application implements CreatableFromArray, Identifiable
{
    private string $id;
    private string $name;
    private string $ownerId;

    private Closure $ownerReference;

    public function __construct(string $id, string $name, string $ownerId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->ownerId = $ownerId;
    }

    /**
     * @inheritDoc
     */
    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Application
    {
        $this->name = $name;
        return $this;
    }

    public function getInitials(): string
    {
        $words = explode(' ', $this->getName());
        $letters = array_map(fn (string $word) => mb_substr($word, 0, 1), $words);
        $two = array_slice($letters, 0, 2);
        return implode($two);
    }

    public function getOwnerId(): string
    {
        return $this->ownerId;
    }

    public function setOwnerId(string $ownerId): Application
    {
        $this->ownerId = $ownerId;
        return $this;
    }

    public function getOwner(): User
    {
        return call_user_func($this->ownerReference, $this->getOwnerId());
    }

    /**
     * @LazyLoad(entity=User::class)
     *
     * @param Closure $ownerReference
     *
     * @internal
     */
    public function setOwner(Closure $ownerReference): void
    {
        $this->ownerReference = $ownerReference;
    }

    /**
     * @inheritDoc
     */
    public static function createFromArray(array $array): self
    {
        return new self($array['id'], $array['name'], $array['owner']);
    }
}
