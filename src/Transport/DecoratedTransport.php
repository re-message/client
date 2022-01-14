<?php
/*
 * This file is a part of Relations Messenger Client.
 * This package is a part of Relations Messenger.
 *
 * @link      https://github.com/relmsg/client
 * @link      https://dev.relmsg.ru/packages/client
 * @copyright Copyright (c) 2018-2022 Relations Messenger
 * @author    Oleg Kozlov <h1karo@relmsg.ru>
 * @license   https://legal.relmsg.ru/licenses/client
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RM\Component\Client\Transport;

use RM\Component\Client\Security\Resolver\AuthorizationResolverInterface;
use RM\Standard\Message\MessageInterface;

/**
 * Class DecoratedTransport.
 *
 * @author Oleg Kozlov <h1karo@relmsg.ru>
 */
abstract class DecoratedTransport implements TransportInterface
{
    private TransportInterface $transport;

    public function __construct(TransportInterface $transport)
    {
        $this->transport = $transport;
    }

    /**
     * {@inheritdoc}
     */
    public function send(MessageInterface $message): MessageInterface
    {
        return $this->transport->send($message);
    }

    /**
     * {@inheritdoc}
     */
    public function setResolver(AuthorizationResolverInterface $resolver): self
    {
        $this->transport->setResolver($resolver);

        return $this;
    }

    public function getTransport(): TransportInterface
    {
        $transport = $this->transport;

        while ($transport instanceof self) {
            $transport = $transport->getTransport();
        }

        return $transport;
    }
}
