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

namespace RM\Component\Client\Transport;

use RM\Component\Client\Security\Resolver\AuthorizationResolverInterface;
use RM\Standard\Message\Serializer\MessageSerializerInterface;

/**
 * Class AbstractTransport.
 *
 * @author Oleg Kozlov <h1karo@relmsg.ru>
 */
abstract class AbstractTransport implements TransportInterface
{
    protected MessageSerializerInterface $serializer;
    protected ?AuthorizationResolverInterface $resolver = null;

    public function __construct(MessageSerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @inheritDoc
     */
    public function setResolver(AuthorizationResolverInterface $resolver): static
    {
        $this->resolver = $resolver;

        return $this;
    }
}
