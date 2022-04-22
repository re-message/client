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

namespace RM\Component\Client\Repository\Factory;

use RM\Component\Client\Repository\RepositoryInterface;

/**
 * Interface RepositoryFactoryInterface.
 *
 * @author Oleg Kozlov <h1karo@remessage.ru>
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
