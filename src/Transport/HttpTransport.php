<?php

namespace RM\Component\Client\Transport;

use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use RM\Component\Client\Exception\TransportException;
use RM\Component\Client\Exception\UnexpectedResponseException;
use RM\Component\Client\Exception\UnserializableMessageException;
use RM\Component\Client\Exception\UnserializableResponseException;
use RM\Component\Client\Security\Resolver\TokenResolverInterface;
use RM\Standard\Message\MessageInterface;
use RM\Standard\Message\Serializer\MessageSerializerInterface;

/**
 * Class HttpTransport
 *
 * @package RM\Component\Client\Transport
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
class HttpTransport extends AbstractTransport
{
    protected const SCHEME = 'https://';
    protected const ENTRYPOINT = 'entrypoint';

    protected ClientInterface $httpClient;
    protected RequestFactoryInterface $requestFactory;
    protected StreamFactoryInterface $streamFactory;

    public function __construct(
        ClientInterface $httpClient,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory,
        MessageSerializerInterface $serializer,
        TokenResolverInterface $tokenResolver
    ) {
        parent::__construct($serializer, $tokenResolver);

        $this->httpClient = $httpClient;
        $this->requestFactory = $requestFactory;
        $this->streamFactory = $streamFactory;
    }

    /**
     * @inheritDoc
     */
    public function send(MessageInterface $message): MessageInterface
    {
        if (!$this->serializer->supports($message)) {
            throw new UnserializableMessageException($message);
        }

        $request = $this->generateRequest($message);
        $response = $this->doSend($request);

        $body = $response->getBody()->getContents();
        if (!$this->serializer->supports($body)) {
            throw new UnserializableResponseException($response);
        }

        return $this->serializer->deserialize($body);
    }

    protected function doSend(RequestInterface $request): ResponseInterface
    {
        try {
            $response = $this->httpClient->sendRequest($request);
            $statusCode = $response->getStatusCode();
            $contentType = $response->getHeader('Content-Type');
            if ($statusCode !== 200 || !in_array('application/json', $contentType, true)) {
                throw new UnexpectedResponseException($response);
            }

            return $response;
        } catch (ClientExceptionInterface $e) {
            throw new TransportException($e);
        }
    }

    protected function generateRequest(MessageInterface $message): RequestInterface
    {
        $body = $this->serializer->serialize($message);
        $stream = $this->streamFactory->createStream($body);

        $url = $this->generateUrl();
        $request = $this->requestFactory
            ->createRequest('POST', $url)
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('User-Agent', 'relmsg/client; v1.0')
            ->withBody($stream);

        $token = $this->resolver->resolve($message);
        if ($token !== null) {
            $request = $request->withHeader('Authorization', 'Bearer ' . $token);
        }

        return $request;
    }

    protected function generateUrl(): string
    {
        $base = self::SCHEME . self::DOMAIN;
        return implode('/', [$base, 'v' . self::VERSION, self::ENTRYPOINT]);
    }
}
