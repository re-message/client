<?php
/*
 * This file is a part of Relations Messenger Client.
 * This package is a part of Relations Messenger.
 *
 * @link      https://github.com/relmsg/client
 * @link      https://dev.relmsg.ru/packages/client
 * @copyright Copyright (c) 2018-2020 Relations Messenger
 * @author    Oleg Kozlov <h1karo@outlook.com>
 * @license   https://legal.relmsg.ru/licenses/client
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RM\Component\Client\Security\Resolver;

use RM\Component\Client\Security\Credentials\AuthorizationInterface;
use RM\Standard\Message\MessageInterface;

/**
 * Interface AuthorizationResolverInterface provides ability to find the authorization for message to Core.
 *
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
interface AuthorizationResolverInterface
{
    /**
     * Returns the authorization object which resolved for this message.
     *
     * @param MessageInterface $message
     *
     * @return AuthorizationInterface|null
     */
    public function resolve(MessageInterface $message): ?AuthorizationInterface;
}
