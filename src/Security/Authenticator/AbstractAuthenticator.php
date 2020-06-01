<?php

namespace RM\Component\Client\Security\Authenticator;

use RM\Component\Client\Repository\RepositoryTrait;
use RM\Standard\Message\MessageInterface;
use RuntimeException;

/**
 * Class AbstractAuthenticator
 *
 * @package RM\Component\Client\Security\Authenticator
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
abstract class AbstractAuthenticator implements AuthenticatorInterface
{
    use RepositoryTrait;

    private const TOKEN_PARAMETER = 'token';

    /**
     * @inheritDoc
     */
    public function authenticate(): object
    {
        $message = $this->createMessage();
        $response = $this->send($message);

        $content = $response->getContent();
        $token = $content[self::TOKEN_PARAMETER];
        $objectData = $content[$this->getObjectKey()];

        $entity = $this->hydrate($objectData);
        if (!is_a($entity, $this->getEntity())) {
            throw new RuntimeException(sprintf('Hydrated entity is not %s.', $this->getEntity()));
        }

        $tokenStorage = $this->transport->getTokenStorage();
        $tokenStorage->set(static::getTokenType(), $token);

        return $entity;
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
