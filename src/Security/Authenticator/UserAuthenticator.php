<?php

namespace RM\Component\Client\Security\Authenticator;

use RM\Component\Client\Entity\User;
use RM\Component\Client\Hydrator\HydratorInterface;
use RM\Component\Client\Model\CodeMethod;
use RM\Component\Client\Model\Preferences;
use RM\Component\Client\Transport\TransportInterface;
use RM\Standard\Message\Action;
use RM\Standard\Message\MessageInterface;

/**
 * Class UserAuthenticator
 *
 * @package RM\Component\Client\Security\Authenticator
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
class UserAuthenticator extends AbstractAuthenticator
{
    private string $phone;
    private Preferences $preferences;

    private string $request;
    private string $code;

    public function __construct(TransportInterface $transport, HydratorInterface $hydrator)
    {
        parent::__construct($transport, $hydrator);
        $this->preferences = new Preferences();
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    public function setPreferences(Preferences $preferences): self
    {
        $this->preferences = $preferences;
        return $this;
    }

    public function getPreferences(): Preferences
    {
        return $this->preferences;
    }

    public function setRequest(string $request): void
    {
        $this->request = $request;
    }

    /**
     * Returns identifier of the auth request.
     *
     * @return string
     */
    public function getRequest(): string
    {
        return $this->request;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;
        return $this;
    }

    public function sendCode(): self
    {
        $message = $this->createCodeMessage();
        $response = $this->send($message);
        $content = $response->getContent();

        $this->request = $content['request'];
        $method = CodeMethod::get($content['method']);
        $this->preferences->setMethod($method);

        return $this;
    }

    protected function createCodeMessage(): MessageInterface
    {
        return new Action(
            'auth.sendCode',
            [
                'phone' => $this->phone,
                'preferences' => $this->preferences->toArray()
            ]
        );
    }

    /**
     * @inheritDoc
     */
    protected function createMessage(): MessageInterface
    {
        return new Action(
            'auth.sendCode',
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
}
