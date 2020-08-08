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


use RM\Component\Client\Hydrator\HydratorInterface;
use RM\Component\Client\Transport\TransportInterface;
use RM\Standard\Message\Action;
use RuntimeException;

/**
 * Class AbstractRepository
 *
 * @author Oleg Kozlov <h1karo@relmsg.ru>
 */
abstract class AbstractRepository implements RepositoryInterface
{
    use RepositoryTrait;

    public function __construct(TransportInterface $transport, HydratorInterface $hydrator)
    {
        $this->transport = $transport;
        $this->hydrator = $hydrator;
    }

    protected function validateEntity(object $entity): void
    {
        $expected = $this->getEntity();
        if (!$entity instanceof $expected) {
            throw new RuntimeException(sprintf('%s supports only %s entities.', static::class, $expected));
        }
    }

    /**
     * @inheritDoc
     */
    public function get(string $id): object
    {
        $entities = $this->getAll([$id]);
        return $entities[0];
    }

    /**
     * @inheritDoc
     */
    public function getAll(array $ids): array
    {
        $action = $this->generateGetAction($ids);
        $response = $this->send($action);

        $entities = [];
        foreach ($response->getContent() as $data) {
            $entity = $this->hydrate($data);
            $this->validateEntity($entity);
            $entities[] = $entity;
        }

        return $entities ?? [];
    }

    /**
     * Generates the {@see Action} message for concrete entity by ids.
     *
     * @example {@see ApplicationRepository::generateGetAction()}
     *
     * @param string[] $ids
     * @return Action
     */
    abstract protected function generateGetAction(array $ids): Action;
}
