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

namespace RM\Component\Client\Repository\Factory;

use RM\Component\Client\Repository\RepositoryInterface;

/**
 * Interface RepositoryFactoryInterface.
 *
 * @author Oleg Kozlov <h1karo@relmsg.ru>
 */
interface RepositoryFactoryInterface
{
    /**
     * Builds the repository by entity class.
     *
     * @param string $entity
     *
     * @return RepositoryInterface
     */
    public function build(string $entity): RepositoryInterface;
}
