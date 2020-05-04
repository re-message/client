<?php

namespace RM\Component\Client\Security\Resolver;

use Doctrine\Common\Collections\Collection;
use Exception;
use RM\Component\Client\Security\Authenticator\ServiceAuthenticator;
use RM\Component\Client\Security\Storage\TokenStorageInterface;
use RM\Standard\Message\MessageInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\LoaderInterface;

/**
 * Class ConfigTokenResolver
 *
 * @package RM\Component\Client\Security\Resolver
 * @author  h1karo <h1karo@outlook.com>
 */
class ConfigTokenResolver implements TokenResolverInterface
{
    private const CONFIG_PATH = 'actions.yaml';
    private const PREFERRED_AUTHORIZATIONS = ['user', ServiceAuthenticator::TOKEN_TYPE];

    private TokenStorageInterface $tokenStorage;
    private LoaderInterface $loader;
    /**
     * @var Collection|ActionConfig[]|null
     */
    private ?Collection $config = null;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;

        $locator = new FileLocator(__DIR__ . '/../../Resources/config');
        $this->loader = new YamlConfigLoader($locator);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function resolve(MessageInterface $message): ?string
    {
        /** @var ActionConfig|null $config */
        $config = $this->getConfig()->get($message->getType());
        if ($config === null) {
            return null;
        }

        if (!$config->isAuthorizationRequired()) {
            return null;
        }

        foreach (self::PREFERRED_AUTHORIZATIONS as $type) {
            if ($config->supportsAuthorization($type) && $this->tokenStorage->has($type)) {
                return $this->tokenStorage->get($type);
            }
        }

        return null;
    }

    /**
     * @return Collection|ActionConfig[]
     * @throws Exception
     */
    protected function getConfig(): Collection
    {
        if ($this->config !== null) {
            return $this->config;
        }

        return $this->config = $this->loader->load(self::CONFIG_PATH);
    }
}
