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

namespace RM\Component\Client\Hydrator;

use RM\Component\Client\Entity\EntityInterface;

/**
 * Interface HydratorInterface creates entity object from response.
 *
 * @author Oleg Kozlov <h1karo@remessage.ru>
 */
interface HydratorInterface
{
    /**
     * Creates a entity by class name and data.
     *
     * @param array  $data
     * @param string $class
     *
     * @return EntityInterface
     */
    public function hydrate(array $data, string $class): EntityInterface;

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
