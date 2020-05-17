<?php

namespace RM\Component\Client\Security\Authenticator;

use RM\Component\Client\Repository\RepositoryTrait;
use RM\Component\Client\Security\Storage\TokenStorageInterface;
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

    /**
     * @inheritDoc
     */
    public function authorize(): object
    {
        $message = $this->createMessage();
        $response = $this->send($message);

        $content = $response->getContent();
        $token = $content['token'];
        $objectData = $content[$this->getObjectKey()];

        $entity = $this->hydrate($objectData);
        if (!is_a($entity, $this->getEntity())) {
            throw new RuntimeException(sprintf('Hydrated entity is not %s.', $this->getEntity()));
        }

        $this->saveToken($token, $this->transport->getTokenStorage());
        return $entity;
    }

    /**
     * Saves received access token into storage.
     *
     * @param string                $token
     * @param TokenStorageInterface $tokenStorage
     */
    protected function saveToken(string $token, TokenStorageInterface $tokenStorage): void
    {
        $tokenStorage->set(static::getTokenType(), $token);
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
