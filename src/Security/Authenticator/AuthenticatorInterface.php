<?php

namespace RM\Component\Client\Security\Authenticator;

use RM\Component\Client\Security\Storage\TokenStorageInterface;
use RM\Component\Client\Transport\TransportInterface;

/**
 * Interface AuthenticatorInterface
 *
 * @package RM\Component\Client\Security\Authenticator
 * @author  h1karo <h1karo@outlook.com>
 */
interface AuthenticatorInterface
{
    public function __construct(TransportInterface $transport, TokenStorageInterface $tokenStorage);

    public function authorize(): object;
}
