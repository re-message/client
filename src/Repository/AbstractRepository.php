<?php

namespace RM\Component\Client\Repository;


use RM\Component\Client\Hydrator\HydratorInterface;
use RM\Component\Client\Transport\TransportInterface;

/**
 * Class AbstractRepository
 *
 * @package RM\Component\Client\Repository
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
abstract class AbstractRepository implements RepositoryInterface
{
    use RepositoryTrait;

    public function __construct(TransportInterface $transport, HydratorInterface $hydrator)
    {
        $this->transport = $transport;
        $this->hydrator = $hydrator;
    }
}
