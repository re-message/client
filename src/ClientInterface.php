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

namespace RM\Component\Client;

use RM\Component\Client\Entity\Application;
use RM\Component\Client\Entity\User;
use RM\Component\Client\Exception\ErrorException;
use RM\Component\Client\Repository\Registry\RepositoryRegistryInterface;
use RM\Component\Client\Security\Authenticator\AuthenticatorInterface;
use RM\Component\Client\Transport\TransportInterface;

/**
 * Interface ClientInterface.
 *
 * @author Oleg Kozlov <h1karo@relmsg.ru>
 */
interface ClientInterface extends RepositoryRegistryInterface, TransportInterface
{
    /**
     * Creates authenticator by the token type.
     *
     * @param string $type The token type (e.g. `user` for user token).
     *
     * @return AuthenticatorInterface
     */
    public function createAuthenticator(string $type): AuthenticatorInterface;

    /**
     * Returns current application which authorized in.
     *
     * @throws ErrorException
     *
     * @return null|Application
     */
    public function getApplication(): ?Application;

    /**
     * Returns current user which authorized in.
     *
     * @throws ErrorException
     *
     * @return null|User
     */
    public function getUser(): ?User;
}
