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

namespace RM\Component\Client\Transport;

use RM\Component\Client\Security\Resolver\AuthorizationResolverInterface;
use RM\Standard\Message\MessageInterface;

/**
 * Interface TransportInterface
 *
 * @author  Oleg Kozlov <h1karo@relmsg.ru>
 */
interface TransportInterface
{
    public const DOMAIN = 'apis.relmsg.ru';
    public const VERSION = '1.0';

    /**
     * Sends the message into server and receive a response message.
     *
     * @param MessageInterface $message
     *
     * @return MessageInterface
     */
    public function send(MessageInterface $message): MessageInterface;

    /**
     * Configures resolver for transport to use authorization in requests.
     *
     * @param AuthorizationResolverInterface $resolver
     *
     * @return self
     */
    public function setResolver(AuthorizationResolverInterface $resolver): self;
}
