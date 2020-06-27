<?php

namespace RM\Component\Client\Security\Authenticator;

use BadMethodCallException;
use RM\Component\Client\Entity\Identifiable;
use RM\Component\Client\Entity\User;
use RM\Component\Client\Security\Credentials\AuthorizationInterface;
use RM\Component\Client\Security\Credentials\Request;
use RM\Component\Client\Security\Credentials\Token;
use RM\Standard\Message\Action;
use RM\Standard\Message\MessageInterface;

/**
 * Class SignInAuthenticator provides ability to complete the authentication started by {@see CodeAuthenticator}.
 *
 * @package RM\Component\Client\Security\Authenticator
 * @author  Oleg Kozlov <h1karo@outlook.com>
 * @link    https://dev.relmsg.ru/security/user
 *
 * @method User authenticate()
 */
class SignInAuthenticator extends DirectAuthenticator implements StatefulAuthenticatorInterface
{
    private ?string $phone;
    private ?string $request;
    private ?string $code;

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Returns the identifier of the auth request.
     *
     * @return string
     */
    public function getRequest(): string
    {
        return $this->request;
    }

    /**
     * Sets the identifier of the auth request.
     *
     * @param string $request
     *
     * @return self
     */
    public function setRequest(string $request): self
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Sets the auth code in authenticator.
     *
     * @param string $code
     *
     * @return self
     */
    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    protected function createMessage(): MessageInterface
    {
        return new Action(
            'auth.signIn',
            [
                'phone' => $this->phone,
                'request' => $this->request,
                'code' => $this->code
            ]
        );
    }

    /**
     * @inheritDoc
     */
    protected function createAuthorization(string $credentials, object $entity): AuthorizationInterface
    {
        if ($entity instanceof Identifiable) {
            return new Token($credentials, $entity->getId());
        }

        throw new BadMethodCallException();
    }

    /**
     * @inheritDoc
     */
    protected function getObjectKey(): string
    {
        return 'user';
    }

    /**
     * @inheritDoc
     */
    public static function getTokenType(): string
    {
        return 'user';
    }

    /**
     * @inheritDoc
     */
    public function getEntity(): string
    {
        return User::class;
    }

    /**
     * @inheritDoc
     */
    public function store(): self
    {
        if ($this->request !== null && $this->phone !== null) {
            $authorization = new Request($this->request, $this->phone);
            $this->storage->set(static::getTokenType(), $authorization);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function restore(): self
    {
        $this->clear();

        $authorization = $this->storage->get(static::getTokenType());
        if ($authorization instanceof Request) {
            $this->request = $authorization->getId();
            $this->phone = $authorization->getPhone();
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function clear(): self
    {
        $this->phone = null;
        $this->request = null;
        $this->code = null;

        return $this;
    }
}
