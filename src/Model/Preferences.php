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

namespace RM\Component\Client\Model;

/**
 * Class RequestPreferences.
 *
 * @author Oleg Kozlov <h1karo@relmsg.ru>
 */
class Preferences
{
    private CodeMethod $method;

    public function __construct()
    {
        $this->method = CodeMethod::get(CodeMethod::AUTO);
    }

    public function getMethod(): CodeMethod
    {
        return $this->method;
    }

    public function setMethod(CodeMethod $method): void
    {
        $this->method = $method;
    }

    public function toArray(): array
    {
        return [
            'method' => $this->method->getValue(),
        ];
    }
}
