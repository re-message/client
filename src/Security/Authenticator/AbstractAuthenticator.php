<?php

namespace RM\Component\Client\Security\Authenticator;

use RM\Component\Client\Hydrator\HydratorInterface;
use RM\Component\Client\Repository\RepositoryTrait;
use RM\Component\Client\Security\Storage\TokenStorageInterface;
use RM\Component\Client\Transport\TransportInterface;
use RM\Standard\Message\MessageInterface;
use RuntimeException;

/**
 * Class AbstractAuthenticator
 *
 * @package RM\Component\Client\Security\Authenticator
 * @author  h1karo <h1karo@outlook.com>
 */
abstract class AbstractAuthenticator implements AuthenticatorInterface
{
    use RepositoryTrait;

    private TokenStorageInterface $tokenStorage;

    public function __construct(
        TransportInterface $transport,
        HydratorInterface $hydrator,
        TokenStorageInterface $tokenStorage
    ) {
        $this->transport = $transport;
        $this->hydrator = $hydrator;
        $this->tokenStorage = $tokenStorage;
    }

    public function authorize(): object
    {
        $message = $this->createMessage();
        $response = $this->send($message);

        $content = $response->getContent();
        $token = $content['token'];
        $objectData = $content[$this->getObjectKey()];

        $object = $this->hydrate($objectData);
        if (!is_a($object, $this->getEntity())) {
            throw new RuntimeException(sprintf('Hydrated entity is not %s.', $this->getEntity()));
        }

        $this->tokenStorage->set(static::getTokenType(), $token);
        return $object;
    }

    /**
     * Returns generated message to for authorization.
     *
     * @return MessageInterface
     */
    abstract protected function createMessage(): MessageInterface;

    /**
     * Returns key of object location in the response content.
     *
     * @return string
     */
    abstract protected function getObjectKey(): string;
}
