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

namespace RM\Component\Client\Repository\Registry;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use RM\Component\Client\Repository\Factory\RepositoryFactoryInterface;
use RM\Component\Client\Repository\RepositoryInterface;

/**
 * Class RepositoryRegistry.
 *
 * @author Oleg Kozlov <h1karo@remessage.ru>
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
     * @inheritDoc
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
