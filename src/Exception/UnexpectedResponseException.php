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

namespace RM\Component\Client\Exception;

use Psr\Http\Message\ResponseInterface;
use RuntimeException;
use Throwable;

/**
 * Class UnexpectedResponseException.
 *
 * @author Oleg Kozlov <h1karo@relmsg.ru>
 */
class UnexpectedResponseException extends RuntimeException implements ExceptionInterface
{
    use ResponsableExceptionTrait;

    public function __construct(ResponseInterface $reason, Throwable $previous = null)
    {
        parent::__construct('The received response is invalid.', 0, $previous);
        $this->reason = $reason;
    }
}
