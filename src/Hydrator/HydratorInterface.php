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

namespace RM\Component\Client\Hydrator;

/**
 * Interface HydratorInterface creates entity object from response.
 *
 * @author  Oleg Kozlov <h1karo@relmsg.ru>
 */
interface HydratorInterface
{
    /**
     * Creates a object by class name and data.
     *
     * @param array  $data
     * @param string $class
     *
     * @return mixed
     */
    public function hydrate(array $data, string $class);

    /**
     * Checks that current hydrator supports this data and class.
     *
     * @param array  $data
     * @param string $class
     *
     * @return bool
     */
    public function supports(array $data, string $class): bool;
}
