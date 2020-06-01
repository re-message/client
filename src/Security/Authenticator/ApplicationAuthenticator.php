<?php

namespace RM\Component\Client\Security\Authenticator;

use RM\Component\Client\Entity\Application;
use RM\Component\Client\Repository\RepositoryTrait;
use RM\Standard\Message\Action;
use RM\Standard\Message\MessageInterface;
use RuntimeException;

/**
 * Class ApplicationAuthenticator
 *
 * @package RM\Component\Client\Security\Authenticator
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
class ApplicationAuthenticator implements AuthenticatorInterface
{
    use RepositoryTrait;

    private const TOKEN_PARAMETER = 'token';
    private const OBJECT_PARAMETER = 'application';

    private string $id;
    private string $secret;

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setSecret(string $secret): self
    {
        $this->secret = $secret;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function authorize(): object
    {
        $message = $this->createMessage();
        $response = $this->send($message);

        $content = $response->getContent();
        $token = $content[self::TOKEN_PARAMETER];
        $objectData = $content[self::OBJECT_PARAMETER];

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
    protected function createMessage(): MessageInterface
    {
        return new Action(
            'auth.authorize',
            [
                'application' => $this->id,
                'secret' => $this->secret
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function getEntity(): string
    {
        return Application::class;
    }

    /**
     * @inheritDoc
     */
    public static function getTokenType(): string
    {
        return 'service';
    }
}
