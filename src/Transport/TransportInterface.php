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

use RM\Component\Client\Exception\ErrorException;
use RM\Component\Client\Security\Resolver\AuthorizationResolverInterface;
use RM\Standard\Message\MessageInterface;

/**
 * Interface TransportInterface.
 *
 * @author Oleg Kozlov <h1karo@remessage.ru>
 */
interface TransportInterface
{
    /**
     * Sends the message into server and receive a response message.
     *
     * @throws ErrorException
     */
    public function send(MessageInterface $message): MessageInterface;

    /**
     * Configures resolver for transport to use authorization in requests.
     */
    public function setResolver(AuthorizationResolverInterface $resolver): static;
}
