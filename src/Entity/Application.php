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

namespace RM\Component\Client\Entity;

use Closure;
use RM\Component\Client\Annotation\Entity;
use RM\Component\Client\Annotation\LazyLoad;
use RM\Component\Client\Repository\ApplicationRepository;

/**
 * @Entity(repositoryClass=ApplicationRepository::class)
 *
 * @author Oleg Kozlov <h1karo@remessage.ru>
 */
class Application implements EntityInterface
{
    protected string $id;

    protected string $name;

    protected string $ownerId;

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
    final public function getId(): string
    {
        return $this->id;
    }

    final public function getName(): string
    {
        return $this->name;
    }

    final public function setName(string $name): Application
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

    final public function getOwnerId(): string
    {
        return $this->ownerId;
    }

    final public function setOwnerId(string $ownerId): Application
    {
        $this->ownerId = $ownerId;

        return $this;
    }

    final public function getOwner(): User
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
    final public function setOwner(Closure $ownerReference): void
    {
        $this->ownerReference = $ownerReference;
    }

    /**
     * @inheritDoc
     */
    final public static function createFromArray(array $array): static
    {
        return new static($array['id'], $array['name'], $array['owner']);
    }
}
