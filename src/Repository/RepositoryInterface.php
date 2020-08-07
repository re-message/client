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

/**
 * Interface RepositoryInterface
 *
 * @author Oleg Kozlov <h1karo@relmsg.ru>
 */
interface RepositoryInterface
{
    public function __construct(TransportInterface $transport, HydratorInterface $hydrator);

    /**
     * Returns entity by identifier.
     *
     * @param string $id
     *
     * @return object
     */
    public function get(string $id): object;

    /**
     * Returns entities by identifiers.
     *
     * @param string[] $ids
     *
     * @return object[]
     */
    public function getAll(array $ids): array;

    /**
     * Returns FQCN of entity.
     *
     * @return string
     */
    public function getEntity(): string;
}
