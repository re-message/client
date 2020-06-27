<?php
/*
 * This file is a part of Relations Messenger Client.
 * This package is a part of Relations Messenger.
 *
 * @link      https://github.com/relmsg/client
 * @link      https://dev.relmsg.ru/packages/client
 * @copyright Copyright (c) 2018-2020 Relations Messenger
 * @author    Oleg Kozlov <h1karo@outlook.com>
 * @license   https://legal.relmsg.ru/licenses/client
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RM\Component\Client\Repository;

use RM\Component\Client\Entity\User;
use RM\Standard\Message\Action;
use RuntimeException;

/**
 * Class UserRepository
 *
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
class UserRepository extends AbstractRepository
{
    /**
     * @inheritDoc
     */
    final public function get(string $id): User
    {
        $users = $this->getAll([$id]);
        return $users[0];
    }

    /**
     * @inheritDoc
     *
     * @return User[]
     */
    final public function getAll(array $ids): array
    {
        $action = new Action('users.get', ['id' => $ids]);
        $response = $this->send($action);
        $data = $response->getContent()['users'];

        $users = [];
        foreach ($data as $userData) {
            $user = $this->hydrate($userData);

            if (!$user instanceof User) {
                throw new RuntimeException(sprintf('Hydrated entity is not %s.', User::class));
            }

            $users[] = $user;
        }

        return $users;
    }

    /**
     * @inheritDoc
     */
    public function getEntity(): string
    {
        return User::class;
    }
}
