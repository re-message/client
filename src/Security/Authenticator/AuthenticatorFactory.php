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
    public const AUTHENTICATORS = [
        ServiceAuthenticator::class
    ];

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
    public function build(string $type): AuthenticatorInterface
    {
        if (null === $class = $this->findAuthenticatorClass($type)) {
            throw new InvalidArgumentException(sprintf('Authenticator with name `%s` does not exist.', $type));
        }

        return $class($this->transport, $this->hydrator);
    }

    private function findAuthenticatorClass(string $type): ?string
    {
        /** @var AuthenticatorInterface $class */
        foreach (self::AUTHENTICATORS as $class) {
            if ($class::getTokenType() === $type) {
                return $class;
            }
        }

        return null;
    }
}
