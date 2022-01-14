<?php
/*
 * This file is a part of Relations Messenger Client.
 * This package is a part of Relations Messenger.
 *
 * @link      https://github.com/relmsg/client
 * @link      https://dev.relmsg.ru/packages/client
 * @copyright Copyright (c) 2018-2022 Relations Messenger
 * @author    Oleg Kozlov <h1karo@relmsg.ru>
 * @license   https://legal.relmsg.ru/licenses/client
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RM\Component\Client\Event;

use RM\Component\Client\Entity\EntityInterface;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class HydratedEvent.
 *
 * @author Oleg Kozlov <h1karo@relmsg.ru>
 */
class HydratedEvent extends Event
{
    private EntityInterface $entity;

    public function __construct(EntityInterface $entity)
    {
        $this->entity = $entity;
    }

    public function getEntity(): EntityInterface
    {
        return $this->entity;
    }

    public function setEntity(EntityInterface $entity): self
    {
        $this->entity = $entity;

        return $this;
    }
}
