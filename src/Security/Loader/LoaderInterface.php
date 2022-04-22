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

namespace RM\Component\Client\Security\Loader;

use Doctrine\Common\Collections\Collection;
use RM\Component\Client\Security\Config\Action;
use Symfony\Component\Config\Loader\LoaderInterface as SymfonyLoaderInterface;

/**
 * Interface LoaderInterface provides ability to load configurations from resource.
 *
 * @author Oleg Kozlov <h1karo@remessage.ru>
 */
interface LoaderInterface extends SymfonyLoaderInterface
{
    /**
     * Loads a configuration for actions from the resource.
     *
     * @inheritDoc
     *
     * @return Collection<string, Action>
     */
    public function load($resource, string $type = null): Collection;
}
