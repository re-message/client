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

namespace RM\Component\Client\Hydrator;

/**
 * Class DecoratedHydrator
 *
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
abstract class DecoratedHydrator implements HydratorInterface
{
    private HydratorInterface $hydrator;

    public function __construct(HydratorInterface $hydrator)
    {
        $this->hydrator = $hydrator;
    }

    /**
     * @inheritDoc
     */
    public function hydrate(array $data, string $class)
    {
        return $this->hydrator->hydrate($data, $class);
    }

    /**
     * @inheritDoc
     */
    public function supports(array $data, string $class): bool
    {
        return $this->hydrator->supports($data, $class);
    }
}
