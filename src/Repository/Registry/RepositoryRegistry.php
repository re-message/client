<?php
/*
 * This file is a part of Relations Messenger Client.
 * This package is a part of Relations Messenger.
 *
 * @link      https://github.com/relmsg/client
 * @link      https://dev.relmsg.ru/packages/client
 * @copyright Copyright (c) 2018-2022 Relations Messenger
 * @author    Oleg Kozlov <h1karo@relmsg.ru>
 * @license   https://legal.relmsg.ru/licenses/client
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RM\Component\Client\Repository\Registry;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use RM\Component\Client\Repository\Factory\RepositoryFactoryInterface;
use RM\Component\Client\Repository\RepositoryInterface;

/**
 * Class RepositoryRegistry.
 *
 * @author Oleg Kozlov <h1karo@relmsg.ru>
 */
class RepositoryRegistry implements RepositoryRegistryInterface
{
    private RepositoryFactoryInterface $factory;

    /**
     * @var Collection<string, RepositoryInterface>
     */
    private Collection $repositories;

    public function __construct(RepositoryFactoryInterface $factory)
    {
        $this->factory = $factory;
        $this->repositories = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getRepository(string $entity): RepositoryInterface
    {
        if ($this->repositories->containsKey($entity)) {
            return $this->repositories->get($entity);
        }

        $repository = $this->factory->build($entity);
        $this->repositories->set($entity, $repository);

        return $repository;
    }
}
