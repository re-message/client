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

namespace RM\Component\Client;

use RM\Component\Client\Entity\Application;
use RM\Component\Client\Entity\User;
use RM\Component\Client\Exception\ErrorException;
use RM\Component\Client\Repository\Registry\RepositoryRegistryInterface;
use RM\Component\Client\Security\Authenticator\AuthenticatorInterface;
use RM\Component\Client\Transport\TransportInterface;

/**
 * @author Oleg Kozlov <h1karo@remessage.ru>
 */
interface ClientInterface extends RepositoryRegistryInterface, TransportInterface
{
    /**
     * Creates authenticator by the token type.
     *
     * @param string $type The token type (e.g. `user` for user token).
     */
    public function createAuthenticator(string $type): AuthenticatorInterface;

    /**
     * Returns current application which authorized in.
     *
     * @throws ErrorException
     */
    public function getApplication(): ?Application;

    /**
     * Returns current user which authorized in.
     *
     * @throws ErrorException
     */
    public function getUser(): ?User;
}
