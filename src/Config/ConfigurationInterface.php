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
 * @author Oleg Kozlov <h1karo@relmsg.ru>
 */
interface ConfigurationInterface
{
    public const DOMAIN = 'apis.remessage.ru';

    public const VERSION = '1.0';

    public function getDomain(): string;

    public function getVersion(): string;

    public function createAddress(): string;
}
