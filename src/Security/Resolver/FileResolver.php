<?php
/*
 * This file is a part of Relations Messenger Client.
 * This package is a part of Relations Messenger.
 *
 * @link      https://github.com/relmsg/client
 * @link      https://dev.relmsg.ru/packages/client
 * @copyright Copyright (c) 2018-2020 Relations Messenger
 * @author    Oleg Kozlov <h1karo@outlook.com>
 * @license   https://legal.relmsg.ru/licenses/client
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
 * Class FileResolver
 *
 * @author  Oleg Kozlov <h1karo@outlook.com>
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
     * @throws Exception
     */
    public function resolve(MessageInterface $message): ?AuthorizationInterface
    {
        if (!$message instanceof Action) {
            return null;
        }

        /** @var ActionConfig|null $config */
        $config = $this->getConfig()->get($message->getName());
        if ($config === null) {
            return null;
        }

        if (!$config->isAuthorizationRequired()) {
            return null;
        }

        foreach ($this->preferredAuthorizations as $type) {
            if ($config->supportsAuthorization($type) && $this->storage->has($type)) {
                return $this->storage->get($type);
            }
        }

        return null;
    }

    /**
     * @return Collection
     * @throws Exception
     */
    protected function getConfig(): Collection
    {
        static $config = null;
        if ($config === null) {
            $config = $this->loader->load($this->path);
        }

        return $config;
    }
}
