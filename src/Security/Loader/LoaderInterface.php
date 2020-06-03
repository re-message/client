<?php

namespace RM\Component\Client\Security\Loader;

use Doctrine\Common\Collections\Collection;
use RM\Component\Client\Security\Config\Action;
use Symfony\Component\Config\Loader\LoaderInterface as SymfonyLoaderInterface;

/**
 * Interface LoaderInterface
 *
 * @package RM\Component\Client\Security\Config\Loader
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
interface LoaderInterface extends SymfonyLoaderInterface
{
    /**
     * Loads an actions configuration from the resource.
     *
     * @return Collection|Action[]
     *
     * @inheritDoc
     */
    public function load($resource, string $type = null): Collection;
}
