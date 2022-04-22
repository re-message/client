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

namespace RM\Component\Client\Security\Authenticator;

use RM\Component\Client\Hydrator\HydratorInterface;
use RM\Component\Client\Transport\TransportInterface;

/**
 * Interface AuthenticatorInterface provides ability to authenticate entity objects via Core.
 *
 * @author Oleg Kozlov <h1karo@remessage.ru>
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
