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

namespace RM\Component\Client\Config;

/**
 * @author Oleg Kozlov <h1karo@remessage.ru>
 */
class HttpConfiguration implements ConfigurationInterface
{
    public const ENTRYPOINT = 'entrypoint';

    private const PROTOCOL = 'https';

    private const VERSION_PREFIX = 'v';

    public function __construct(
        private readonly string $domain = self::DOMAIN,
        private readonly string $version = self::VERSION,
        private readonly string $entrypoint = self::ENTRYPOINT,
    ) {
    }

    public function getDomain(): string
    {
        return $this->domain;
    }

    public function getVersion(): string
    {
        return self::VERSION_PREFIX . ltrim($this->version, self::VERSION_PREFIX);
    }

    public function getEntrypoint(): string
    {
        return $this->entrypoint;
    }

    public function getPath(): string
    {
        return $this->getVersion() . '/' . $this->getEntrypoint();
    }

    public function getScheme(): string
    {
        return self::PROTOCOL . '://';
    }

    public function createAddress(): string
    {
        return $this->getScheme() . $this->getDomain() . '/' . $this->getPath();
    }
}
