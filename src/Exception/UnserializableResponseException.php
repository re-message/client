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

use Psr\Http\Message\ResponseInterface;
use RM\Standard\Message\MessageInterface;
use RuntimeException;
use Throwable;

/**
 * Class UnserializableResponseException throws when the serializer cannot deserialize a body of the received response
 * into {@see MessageInterface}.
 *
 * @author Oleg Kozlov <h1karo@remessage.ru>
 */
class UnserializableResponseException extends RuntimeException implements ExceptionInterface
{
    use ResponsableExceptionTrait;

    public function __construct(ResponseInterface $reason, Throwable $previous = null)
    {
        parent::__construct('The received body cannot be serialized.', 0, $previous);
        $this->reason = $reason;
    }
}
