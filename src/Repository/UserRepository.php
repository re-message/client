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

use RM\Component\Client\Entity\User;
use RM\Standard\Message\Action;

/**
 * @author Oleg Kozlov <h1karo@remessage.ru>
 *
 * @method User   find(string $id)
 * @method User[] findAll(string[] $ids)
 */
class UserRepository extends AbstractRepository
{
    /**
     * @inheritDoc
     */
    final protected function generateGetAction(array $ids): Action
    {
        return new Action('users.get', ['id' => $ids]);
    }

    /**
     * @inheritDoc
     */
    public function getEntity(): string
    {
        return User::class;
    }
}
