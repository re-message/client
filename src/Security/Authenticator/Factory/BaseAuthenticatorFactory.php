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

namespace RM\Component\Client\Security\Authenticator\Factory;

use InvalidArgumentException;
use RM\Component\Client\Hydrator\HydratorInterface;
use RM\Component\Client\Security\Authenticator\AuthenticatorInterface;
use RM\Component\Client\Security\Authenticator\RedirectAuthenticatorInterface;
use RM\Component\Client\Security\Authenticator\StorableAuthenticatorInterface;
use RM\Component\Client\Security\Storage\AuthorizationStorageInterface;
use RM\Component\Client\Transport\TransportInterface;

/**
 * Class BaseAuthenticatorFactory
 *
 * @author  Oleg Kozlov <h1karo@relmsg.ru>
 */
class BaseAuthenticatorFactory implements AuthenticatorFactoryInterface
{
    private TransportInterface $transport;
    private HydratorInterface $hydrator;
    private AuthorizationStorageInterface $storage;

    public function __construct(
        TransportInterface $transport,
        HydratorInterface $hydrator,
        AuthorizationStorageInterface $storage
    ) {
        $this->transport = $transport;
        $this->hydrator = $hydrator;
        $this->storage = $storage;
    }

    /**
     * @inheritDoc
     */
    public function build(string $class): AuthenticatorInterface
    {
        if (!class_exists($class)) {
            throw new InvalidArgumentException(sprintf('Authenticator class `%s` does not exist.', $class));
        }

        $authenticator = new $class($this->transport, $this->hydrator);

        if ($authenticator instanceof RedirectAuthenticatorInterface) {
            $authenticator->setFactory($this);
        }

        if ($authenticator instanceof StorableAuthenticatorInterface) {
            $authenticator->setStorage($this->storage);
        }

        return $authenticator;
    }
}
