<?php

namespace RM\Component\Client\Security\Authenticator;

use InvalidArgumentException;
use RM\Component\Client\Hydrator\HydratorInterface;
use RM\Component\Client\Transport\TransportInterface;

/**
 * Class AuthenticatorFactory
 *
 * @package RM\Component\Client\Security\Authenticator
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
class AuthenticatorFactory implements AuthenticatorFactoryInterface
{
    private TransportInterface $transport;
    private HydratorInterface $hydrator;

    public function __construct(TransportInterface $transport, HydratorInterface $hydrator)
    {
        $this->transport = $transport;
        $this->hydrator = $hydrator;
    }

    /**
     * @inheritDoc
     */
    public function build(string $class): AuthenticatorInterface
    {
        if (!class_exists($class)) {
            throw new InvalidArgumentException(sprintf('Authenticator class `%s` does not exist.', $class));
        }

        $authenticator = $class($this->transport, $this->hydrator);

        if ($authenticator instanceof RedirectAuthenticatorInterface) {
            $authenticator->setFactory($this);
        }

        return $authenticator;
    }
}
