<?php
/*
 * This file is a part of Re Message Client.
 * This package is a part of Re Message.
 *
 * @link      https://github.com/re-message/client
 * @link      https://dev.remessage.ru/packages/client
 * @copyright Copyright (c) 2018-2022 Re Message
 * @author    Oleg Kozlov <h1karo@remessage.ru>
 * @license   Apache License 2.0
 * @license   https://legal.remessage.ru/licenses/client
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
 * @see https://dev.remessage.ru/security/user
 *
 * @method User authenticate()
 *
 * @author Oleg Kozlov <h1karo@remessage.ru>
 */
class SignInAuthenticator extends DirectAuthenticator implements StatefulAuthenticatorInterface
{
    private ?string $phone;
    private ?string $request;
    private ?string $code;

    public function setPhone(string $phone): static
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
     */
    public function setRequest(string $request): static
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Sets the auth code in authenticator.
     */
    public function setCode(string $code): static
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
                'code' => $this->code,
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
    public function store(): static
    {
        if (null !== $this->request && null !== $this->phone) {
            $authorization = new Request($this->request, $this->phone);
            $this->storage->set(static::getTokenType(), $authorization);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function restore(): static
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
    public function clear(): static
    {
        $this->phone = null;
        $this->request = null;
        $this->code = null;

        return $this;
    }
}
