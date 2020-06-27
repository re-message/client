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
use RM\Standard\Message\MessageInterface;
use RM\Standard\Message\Response;
use RuntimeException;

/**
 * Trait RepositoryTrait
 *
 * @author  Oleg Kozlov <h1karo@relmsg.ru>
 */
trait RepositoryTrait
{
    protected TransportInterface $transport;
    protected HydratorInterface $hydrator;

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
