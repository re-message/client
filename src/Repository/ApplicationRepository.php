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

use RM\Component\Client\Entity\Application;
use RM\Standard\Message\Action;

/**
 * Class ApplicationRepository
 *
 * @author Oleg Kozlov <h1karo@relmsg.ru>
 */
class ApplicationRepository extends AbstractRepository
{
    /**
     * @inheritDoc
     */
    final public function get(string $id): Application
    {
        $applications = $this->getAll([$id]);
        return $applications[0];
    }

    /**
     * @inheritDoc
     *
     * @return Application[]
     */
    final public function getAll(array $ids): array
    {
        $action = new Action('apps.get', ['id' => $ids]);
        $response = $this->send($action);

        foreach ($response->getContent() as $data) {
            $application = $this->hydrate($data);
            $this->validateEntity($application);
            $applications[] = $application;
        }

        return $applications ?? [];
    }

    /**
     * @inheritDoc
     */
    public function getEntity(): string
    {
        return Application::class;
    }
}
