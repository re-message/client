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
 * Class ApplicationRepository.
 *
 * @author Oleg Kozlov <h1karo@relmsg.ru>
 *
 * @method Application   get(string $id)
 * @method Application[] getAll(string[] $ids)
 */
class ApplicationRepository extends AbstractRepository
{
    /**
     * {@inheritdoc}
     */
    final protected function generateGetAction(array $ids): Action
    {
        return new Action('apps.get', ['id' => $ids]);
    }

    /**
     * {@inheritdoc}
     */
    public function getEntity(): string
    {
        return Application::class;
    }
}
