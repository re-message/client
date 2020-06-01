<?php

namespace RM\Component\Client\Repository\Factory;

use Doctrine\Common\Annotations\Reader;
use RM\Component\Client\Hydrator\HydratorInterface;
use RM\Component\Client\Transport\TransportInterface;
use RM\Component\Client\Repository\RepositoryInterface;

/**
 * Class RepositoryFactory
 *
 * @package RM\Component\Client\Repository\Factory
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
class RepositoryFactory extends AbstractFactory
{
    private TransportInterface $transport;
    private HydratorInterface $hydrator;

    public function __construct(TransportInterface $transport, HydratorInterface $hydrator, ?Reader $reader = null)
    {
        parent::__construct($reader);
        $this->transport = $transport;
        $this->hydrator = $hydrator;
    }

    /**
     * @inheritDoc
     */
    public function build(string $entity): RepositoryInterface
    {
        $repositoryClass = $this->getRepositoryClass($entity);
        return new $repositoryClass($this->transport, $this->hydrator);
    }
}
