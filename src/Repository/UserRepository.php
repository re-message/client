<?php

namespace RM\Component\Client\Repository;

use RM\Component\Client\Entity\User;
use RM\Standard\Message\Action;
use RuntimeException;

/**
 * Class UserRepository
 *
 * @package RM\Component\Client\Repository
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
     * Returns users by id.
     *
     * @param int[] $ids
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
