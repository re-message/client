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

namespace RM\Component\Client\Transport;

use RM\Component\Client\Config\ConfigurationInterface;
use RM\Component\Client\Security\Resolver\AuthorizationResolverInterface;
use RM\Standard\Message\Serializer\MessageSerializerInterface;

/**
 * Class AbstractTransport.
 *
 * @author Oleg Kozlov <h1karo@remessage.ru>
 */
abstract class AbstractTransport implements TransportInterface
{
    protected MessageSerializerInterface $serializer;
    protected ConfigurationInterface $configuration;
    protected ?AuthorizationResolverInterface $resolver = null;

    public function __construct(
        MessageSerializerInterface $serializer,
        ConfigurationInterface $configuration,
    ) {
        $this->serializer = $serializer;
        $this->configuration = $configuration;
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
