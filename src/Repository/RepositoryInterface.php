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

namespace RM\Component\Client\Repository;

use RM\Component\Client\Entity\EntityInterface;
use RM\Component\Client\Hydrator\HydratorInterface;
use RM\Component\Client\Transport\TransportInterface;

/**
 * @author Oleg Kozlov <h1karo@remessage.ru>
 */
interface RepositoryInterface
{
    public function __construct(TransportInterface $transport, HydratorInterface $hydrator);

    /**
     * Returns entity by identifier.
     *
     * @param string $id
     *
     * @return EntityInterface
     */
    public function find(string $id): EntityInterface;

    /**
     * Returns entities by identifiers.
     *
     * @param string[] $ids
     *
     * @return EntityInterface[]
     */
    public function findAll(array $ids): array;

    /**
     * Returns FQCN of entity.
     *
     * @return string
     */
    public function getEntity(): string;
}
