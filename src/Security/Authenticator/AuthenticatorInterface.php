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

namespace RM\Component\Client\Security\Authenticator;

use RM\Component\Client\Hydrator\HydratorInterface;
use RM\Component\Client\Transport\TransportInterface;

/**
 * Interface AuthenticatorInterface provides ability to authenticate entity objects via Core.
 *
 * @author  Oleg Kozlov <h1karo@relmsg.ru>
 */
interface AuthenticatorInterface
{
    public function __construct(TransportInterface $transport, HydratorInterface $hydrator);

    /**
     * Puts the received access token into the token storage and returns the object.
     *
     * @return object
     */
    public function authenticate(): object;

    /**
     * Returns type of the token that will be received in {@see authenticate}.
     *
     * @return string
     */
    public static function getTokenType(): string;
}
