<?php
/*
 * This file is a part of Relations Messenger Client.
 * This package is a part of Relations Messenger.
 *
 * @link      https://github.com/relmsg/client
 * @link      https://dev.relmsg.ru/packages/client
 * @copyright Copyright (c) 2018-2020 Relations Messenger
 * @author    Oleg Kozlov <h1karo@outlook.com>
 * @license   https://legal.relmsg.ru/licenses/client
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RM\Component\Client\Transport;

use RM\Component\Client\Exception\ErrorException;
use RM\Component\Client\Exception\UnexpectedMessageException;
use RM\Standard\Message\Error;
use RM\Standard\Message\MessageInterface;
use RM\Standard\Message\Response;

/**
 * Class ThrowableTransport decorates transport to throw exception on errors.
 *
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
class ThrowableTransport extends DecoratedTransport
{
    /**
     * @inheritDoc
     * @throws ErrorException
     */
    public function send(MessageInterface $message): MessageInterface
    {
        $response = parent::send($message);

        if ($response instanceof Error) {
            throw new ErrorException($response);
        }

        if (!$response instanceof Response) {
            throw new UnexpectedMessageException($response, Response::class);
        }

        return $response;
    }
}
