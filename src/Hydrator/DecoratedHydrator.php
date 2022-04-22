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

namespace RM\Component\Client\Hydrator;

use RM\Component\Client\Entity\EntityInterface;

/**
 * @author Oleg Kozlov <h1karo@remessage.ru>
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
    public function hydrate(array $data, string $class): EntityInterface
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

    public function getHydrator(): HydratorInterface
    {
        $hydrator = $this->hydrator;

        while ($hydrator instanceof self) {
            $hydrator = $hydrator->getHydrator();
        }

        return $hydrator;
    }
}
