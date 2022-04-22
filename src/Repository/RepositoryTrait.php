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
use RM\Standard\Message\MessageInterface;
use RM\Standard\Message\Response;
use RuntimeException;

/**
 * @author Oleg Kozlov <h1karo@remessage.ru>
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

    final protected function hydrate(array $data): EntityInterface
    {
        return $this->hydrator->hydrate($data, $this->getEntity());
    }

    /**
     * @inheritDoc
     */
    abstract public function getEntity(): string;
}
