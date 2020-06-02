<?php

namespace RM\Component\Client\Security\Authenticator;

use RM\Component\Client\Hydrator\HydratorInterface;
use RM\Component\Client\Security\Storage\AuthorizationStorageInterface;
use RM\Component\Client\Transport\TransportInterface;

/**
 * Interface AuthenticatorInterface
 *
 * @package RM\Component\Client\Security\Authenticator
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
interface AuthenticatorInterface
{
    public function __construct(
        TransportInterface $transport,
        HydratorInterface $hydrator,
        AuthorizationStorageInterface $storage
    );

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
