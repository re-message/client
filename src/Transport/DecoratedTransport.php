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

namespace RM\Component\Client\Transport;

use RM\Component\Client\Security\Resolver\AuthorizationResolverInterface;
use RM\Standard\Message\MessageInterface;

/**
 * Class DecoratedTransport.
 *
 * @author Oleg Kozlov <h1karo@remessage.ru>
 */
abstract class DecoratedTransport implements TransportInterface
{
    private TransportInterface $transport;

    public function __construct(TransportInterface $transport)
    {
        $this->transport = $transport;
    }

    /**
     * @inheritDoc
     */
    public function send(MessageInterface $message): MessageInterface
    {
        return $this->transport->send($message);
    }

    /**
     * @inheritDoc
     */
    public function setResolver(AuthorizationResolverInterface $resolver): static
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
