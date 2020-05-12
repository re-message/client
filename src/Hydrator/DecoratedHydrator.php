<?php

namespace RM\Component\Client\Hydrator;

/**
 * Class DecoratedHydrator
 *
 * @package RM\Component\Client\Hydrator
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
