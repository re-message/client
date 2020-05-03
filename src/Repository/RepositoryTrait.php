<?php

namespace RM\Component\Client\Repository;

use RM\Component\Client\Hydrator\HydratorInterface;
use RM\Component\Client\Transport\TransportInterface;
use RM\Standard\Message\MessageInterface;
use RM\Standard\Message\Response;
use RuntimeException;

/**
 * Trait RepositoryTrait
 *
 * @package RM\Component\Client\Repository
 * @author  h1karo <h1karo@outlook.com>
 */
trait RepositoryTrait
{
    private TransportInterface $transport;
    private HydratorInterface $hydrator;

    final protected function send(MessageInterface $message): Response
    {
        $message = $this->transport->send($message);

        if (!$message instanceof Response) {
            throw new RuntimeException('Received message is not response message.');
        }

        return $message;
    }

    final protected function hydrate(array $data): object
    {
        return $this->hydrator->hydrate($data, $this->getEntity());
    }

    /**
     * @inheritDoc
     */
    abstract public function getEntity(): string;
}
