<?php

namespace RM\Component\Client\Security\Authenticator;

use RM\Component\Client\Entity\User;
use RM\Component\Client\Security\Credentials\AuthorizationInterface;
use RM\Component\Client\Security\Credentials\TokenAuthorization;
use RM\Standard\Message\Action;
use RM\Standard\Message\MessageInterface;

/**
 * Class SignInAuthenticator
 *
 * @package RM\Component\Client\Security\Authenticator
 * @author  Oleg Kozlov <h1karo@outlook.com>
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

    protected function createAuthorization(string $credentials): AuthorizationInterface
    {
        return new TokenAuthorization($credentials);
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
        // @todo after authorization storage implementation

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function restore(): self
    {
        // @todo after authorization storage implementation

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
