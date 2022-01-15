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

namespace RM\Component\Client\Hydrator;

use RM\Component\Client\Entity\EntityInterface;

/**
 * Class DecoratedHydrator.
 *
 * @author Oleg Kozlov <h1karo@relmsg.ru>
 */
abstract class DecoratedHydrator implements HydratorInterface
{
    private HydratorInterface $hydrator;

    public function __construct(HydratorInterface $hydrator)
    {
        $this->hydrator = $hydrator;
    }

    /**
     * {@inheritdoc}
     */
    public function hydrate(array $data, string $class): EntityInterface
    {
        return $this->hydrator->hydrate($data, $class);
    }

    /**
     * {@inheritdoc}
     */
    public function supports(array $data, string $class): bool
    {
        return $this->hydrator->supports($data, $class);
    }

    public function getHydrator(): HydratorInterface
    {
        $hydrator = $this->hydrator;

        while ($hydrator instanceof self) {
            $hydrator = $hydrator->getHydrator();
        }

        return $hydrator;
    }
}
