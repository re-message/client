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

namespace RM\Component\Client\Repository;


use RM\Component\Client\Hydrator\HydratorInterface;
use RM\Component\Client\Transport\TransportInterface;
use RuntimeException;

/**
 * Class AbstractRepository
 *
 * @author Oleg Kozlov <h1karo@relmsg.ru>
 */
abstract class AbstractRepository implements RepositoryInterface
{
    use RepositoryTrait;

    public function __construct(TransportInterface $transport, HydratorInterface $hydrator)
    {
        $this->transport = $transport;
        $this->hydrator = $hydrator;
    }

    protected function validateEntity(object $entity): void
    {
        $expected = $this->getEntity();
        if (!$entity instanceof $expected) {
            throw new RuntimeException(sprintf('%s supports only %s entities.', static::class, $expected));
        }
    }
}
