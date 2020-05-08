<?php

namespace RM\Component\Client\Security\Authenticator;

use RM\Component\Client\Hydrator\HydratorInterface;
use RM\Component\Client\Security\Storage\ActorStorageInterface;
use RM\Component\Client\Transport\TransportInterface;

/**
 * Interface AuthenticatorInterface
 *
 * @package RM\Component\Client\Security\Authenticator
 * @author  h1karo <h1karo@outlook.com>
 */
interface AuthenticatorInterface
{
    public function __construct(TransportInterface $transport, HydratorInterface $hydrator);

    /**
     * Puts the received access token into the token storage and returns the object.
     *
     * @return object
     */
    public function authorize(): object;

    /**
     * Returns type of the token that will be received in {@see authorize}.
     *
     * @return string
     */
    public static function getTokenType(): string;

    /**
     * Sets subject storage which will used to save received entity.
     *
     * @param ActorStorageInterface $subjectStorage
     *
     * @return self
     * @internal
     */
    public function setSubjectStorage(ActorStorageInterface $subjectStorage): self;
}
