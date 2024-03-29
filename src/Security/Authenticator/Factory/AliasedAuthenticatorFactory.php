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

namespace RM\Component\Client\Security\Authenticator\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use InvalidArgumentException;
use RM\Component\Client\Exception\FactoryException;
use RM\Component\Client\Security\Authenticator\AuthenticatorInterface;
use RM\Component\Client\Security\Authenticator\CodeAuthenticator;
use RM\Component\Client\Security\Authenticator\ServiceAuthenticator;

/**
 * @author Oleg Kozlov <h1karo@remessage.ru>
 */
class AliasedAuthenticatorFactory implements AuthenticatorFactoryInterface
{
    public const DEFAULT_MAP = [
        'user' => CodeAuthenticator::class,
        'code' => CodeAuthenticator::class,
        'service' => ServiceAuthenticator::class,
        'application' => ServiceAuthenticator::class,
    ];

    private AuthenticatorFactoryInterface $factory;
    private Collection $mapping;

    public function __construct(AuthenticatorFactoryInterface $factory, iterable $mapping = self::DEFAULT_MAP)
    {
        $this->factory = $factory;
        $this->mapping = new ArrayCollection();

        foreach ($mapping as $type => $class) {
            $this->putClass($type, $class);
        }
    }

    public function putClass(string $type, string $class): void
    {
        if (!class_exists($class)) {
            throw new InvalidArgumentException(sprintf('Authenticator class `%s` does not exist.', $class));
        }

        $this->mapping->set($type, $class);
    }

    public function build(string $type): AuthenticatorInterface
    {
        $class = $this->findClassByType($type);

        if (null === $class && class_exists($type)) {
            $class = $type;
        } elseif (null === $class) {
            throw new FactoryException(sprintf('Authenticator for type %s not found.', $type));
        }

        return $this->factory->build($class);
    }

    protected function findClassByType(string $type): ?string
    {
        return $this->mapping->get($type);
    }
}
