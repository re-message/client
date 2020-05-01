<?php

namespace RM\Component\Client\Hydrator;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Class AbstractHydrator
 *
 * @package RM\Component\Client\Hydrator
 * @author  h1karo <h1karo@outlook.com>
 */
abstract class AbstractHydrator implements HydratorInterface
{
    /**
     * @var Collection|HydratorLoaderInterface[]
     */
    private Collection $loaders;

    public function __construct(iterable $loaders = [])
    {
        $this->loaders = new ArrayCollection();

        foreach ($loaders as $loader) {
            $this->pushLoader($loader);
        }
    }

    public function pushLoader(HydratorLoaderInterface $loader): void
    {
        $this->loaders->add($loader);
    }

    /**
     * @inheritDoc
     */
    public function hydrate(array $data, string $class)
    {
        $entity = $this->doHydrate($data, $class);

        foreach ($this->loaders as $loader) {
            if ($loader->supports($this, $entity)) {
                $entity = $loader->load($entity);
            }
        }

        return $entity;
    }

    /**
     * Creates a object by class name and data.
     *
     * @param array  $data
     * @param string $class
     *
     * @return mixed
     */
    abstract protected function doHydrate(array $data, string $class);
}