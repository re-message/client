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

use RM\Component\Client\Entity\EntityInterface;
use RM\Component\Client\Hydrator\HydratorInterface;
use RM\Component\Client\Transport\TransportInterface;
use RM\Standard\Message\Action;
use RuntimeException;

/**
 * Class AbstractRepository.
 *
 * @author Oleg Kozlov <h1karo@remessage.ru>
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
    public function find(string $id): EntityInterface
    {
        $entities = $this->findAll([$id]);

        return $entities[0];
    }

    /**
     * @inheritDoc
     */
    public function findAll(array $ids): array
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
     *
     * @return Action
     */
    abstract protected function generateGetAction(array $ids): Action;
}
