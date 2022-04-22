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

namespace RM\Component\Client\Exception;

use RuntimeException;

/**
 * Class TokenNotFoundException.
 *
 * @author Oleg Kozlov <h1karo@remessage.ru>
 */
class TokenNotFoundException extends RuntimeException implements ExceptionInterface
{
    public function __construct(string $type)
    {
        $message = sprintf('The access token with type %s does not exist.', $type);
        parent::__construct($message);
    }
}
