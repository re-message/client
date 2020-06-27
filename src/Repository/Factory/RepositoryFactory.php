<?php
/*
 * This file is a part of Relations Messenger Client.
 * This package is a part of Relations Messenger.
 *
 * @link      https://github.com/relmsg/client
 * @link      https://dev.relmsg.ru/packages/client
 * @copyright Copyright (c) 2018-2020 Relations Messenger
 * @author    Oleg Kozlov <h1karo@relmsg.ru>
 * @license   https://legal.relmsg.ru/licenses/client
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RM\Component\Client\Repository\Factory;

use Doctrine\Common\Annotations\Reader;
use RM\Component\Client\Hydrator\HydratorInterface;
use RM\Component\Client\Transport\TransportInterface;
use RM\Component\Client\Repository\RepositoryInterface;

/**
 * Class RepositoryFactory
 *
 * @author  Oleg Kozlov <h1karo@relmsg.ru>
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
