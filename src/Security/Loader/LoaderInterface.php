<?php
/*
 * This file is a part of Relations Messenger Client.
 * This package is a part of Relations Messenger.
 *
 * @link      https://github.com/relmsg/client
 * @link      https://dev.relmsg.ru/packages/client
 * @copyright Copyright (c) 2018-2020 Relations Messenger
 * @author    Oleg Kozlov <h1karo@relmsg.ru>
 * @license   https://legal.relmsg.ru/licenses/client
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
 * @author Oleg Kozlov <h1karo@relmsg.ru>
 */
interface LoaderInterface extends SymfonyLoaderInterface
{
    /**
     * Loads an actions configuration from the resource.
     *
     * @return Action[]|Collection
     *
     * {@inheritdoc}
     */
    public function load($resource, string $type = null): Collection;
}
