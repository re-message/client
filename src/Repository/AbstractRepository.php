<?php

namespace RM\Component\Client\Repository;

use RM\Component\Client\Hydrator\HydratorInterface;
use RM\Component\Client\Transport\TransportInterface;
use RM\Standard\Message\MessageInterface;

/**
 * Class AbstractRepository
 *
 * @package RM\Component\Client\Repository
 * @author  h1karo <h1karo@outlook.com>
 */
abstract class AbstractRepository implements RepositoryInterface
{
    private TransportInterface $transport;
    private HydratorInterface $hydrator;

    final public function __construct(TransportInterface $transport, HydratorInterface $hydrator)
    {
        $this->transport = $transport;
        $this->hydrator = $hydrator;
    }

    /**
     * @param MessageInterface $message
     *
     * @return MessageInterface
     */
    final protected function send(MessageInterface $message): MessageInterface
    {
        return $this->transport->send($message);
    }

    /**
     * @param array $data
     *
     * @return object
     */
    final protected function hydrate(array $data): object
    {
        return $this->hydrator->hydrate($data, $this->getEntity());
    }

    /**
     * @inheritDoc
     */
    abstract public function getEntity(): string;
}
