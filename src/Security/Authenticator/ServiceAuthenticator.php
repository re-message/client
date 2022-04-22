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
use RM\Component\Client\Entity\Application;
use RM\Component\Client\Entity\Identifiable;
use RM\Component\Client\Security\Credentials\AuthorizationInterface;
use RM\Component\Client\Security\Credentials\Token;
use RM\Standard\Message\Action;
use RM\Standard\Message\MessageInterface;

/**
 * Class ServiceAuthenticator provides ability to authenticate the application.
 *
 * @see https://dev.remessage.ru/security/service
 *
 * @author Oleg Kozlov <h1karo@remessage.ru>
 */
class ServiceAuthenticator extends DirectAuthenticator
{
    private string $id;
    private string $secret;

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function setSecret(string $secret): static
    {
        $this->secret = $secret;

        return $this;
    }

    /**
     * @inheritDoc
     */
    protected function createMessage(): MessageInterface
    {
        return new Action(
            'auth.authorize',
            [
                'application' => $this->id,
                'secret' => $this->secret,
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

    /**
     * @inheritDoc
     */
    protected function getObjectKey(): string
    {
        return 'application';
    }
}
