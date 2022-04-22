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

namespace RM\Component\Client\Repository\Factory;

use Doctrine\Common\Annotations\Reader;
use RM\Component\Client\Hydrator\HydratorInterface;
use RM\Component\Client\Repository\RepositoryInterface;
use RM\Component\Client\Transport\TransportInterface;

/**
 * Class RepositoryFactory.
 *
 * @author Oleg Kozlov <h1karo@remessage.ru>
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
