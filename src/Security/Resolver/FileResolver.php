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

namespace RM\Component\Client\Security\Resolver;

use Doctrine\Common\Collections\Collection;
use Exception;
use RM\Component\Client\Security\Config\Action as ActionConfig;
use RM\Component\Client\Security\Credentials\AuthorizationInterface;
use RM\Component\Client\Security\Loader\LoaderInterface;
use RM\Component\Client\Security\Storage\AuthorizationStorageInterface;
use RM\Standard\Message\Action;
use RM\Standard\Message\MessageInterface;

/**
 * @author Oleg Kozlov <h1karo@remessage.ru>
 */
class FileResolver implements AuthorizationResolverInterface
{
    public const PREFERRED_AUTHORIZATIONS = ['user', 'service'];

    private AuthorizationStorageInterface $storage;
    private LoaderInterface $loader;
    private string $path;
    private iterable $preferredAuthorizations;

    public function __construct(
        AuthorizationStorageInterface $storage,
        LoaderInterface $loader,
        string $path,
        iterable $preferredAuthorizations = self::PREFERRED_AUTHORIZATIONS
    ) {
        $this->storage = $storage;
        $this->loader = $loader;
        $this->path = $path;
        $this->preferredAuthorizations = $preferredAuthorizations;
    }

    /**
     * @inheritDoc
     *
     * @throws Exception
     */
    public function resolve(MessageInterface $message): ?AuthorizationInterface
    {
        if (!$message instanceof Action) {
            return null;
        }

        /** @var null|ActionConfig $config */
        $config = $this->getConfig()->get($message->getName());
        if (null === $config) {
            return null;
        }

        if (!$config->isAuthorizationRequired()) {
            return null;
        }

        foreach ($this->preferredAuthorizations as $type) {
            if (!$config->supportsAuthorization($type)) {
                continue;
            }

            if (!$this->storage->has($type)) {
                continue;
            }

            $authorization = $this->storage->get($type);
            if (!$authorization->isCompleted()) {
                continue;
            }

            return $authorization;
        }

        return null;
    }

    /**
     * @throws Exception
     */
    protected function getConfig(): Collection
    {
        static $config = null;
        if (null === $config) {
            $config = $this->loader->load($this->path);
        }

        return $config;
    }
}
