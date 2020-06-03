# Relations Messenger Client

This package provides an object-oriented client level to interact with Relations Messenger Core. The package architecture inspired by DBAL and Doctrine packages.

Client uses the specific version when sends messages to Core.

![Package version](https://img.shields.io/packagist/v/relmsg/client?style=for-the-badge)
![Core version](https://img.shields.io/static/v1?label=Core%20version&message=1.0&color=blue&style=for-the-badge)
![PHP Version](https://img.shields.io/static/v1?label=PHP&message=^7.4&color=blue&style=for-the-badge)

## Requirements

1. PHP 7.4+
2. Any `psr/http-client` compatible package to send HTTP requests

## Installation

You will need Composer to install:

`composer require relmsg/client`

## Usage

To create an instance of client, you need to choose transport. Now available only HTTP protocol transport. This transport can work with PSR 7, PSR 17, PSR 18 implementation. For example, `symfony/http-client`. We will use this package as http client in next examples.

Any transport requires message serializer from `relmsg/message` package. You can use `RM\Standard\Message\Serializer\ChainMessageSerializer` class to pass serializers for each message type.

After creation of transport instance, you can use `RM\Component\Client\ClientFactory` to create an instance of client. This class has several setters that provide client customization. In any case, you need to configure the following properties: 

* The transport (it is required in constructor and `create()` method)

Also, you can configure these properties:

* The hydrator, creates entity objects from response
* The repository registry, contains repositories created via factory
* The repository factory, creates repositories
* The authenticator factory, creates authenticators
* The authorization storage, stores the authorization data like token.
* The authorization resolver, finds credentials to pass together with request to core
* The config loader, loads the action config from resource with settings for authorization resolver


Example of creation client with HTTP transport:

```php
use RM\Component\Client\ClientFactory;
use RM\Component\Client\Transport\HttpTransport;
use RM\Standard\Message\Serializer\ActionSerializer;
use RM\Standard\Message\Serializer\ChainMessageSerializer;
use RM\Standard\Message\Serializer\ErrorSerializer;
use RM\Standard\Message\Serializer\ResponseSerializer;
use Symfony\Component\HttpClient\Psr18Client;

$http = new Psr18Client();

$serializer = new ChainMessageSerializer();
$serializer->pushSerializer(new ActionSerializer());
$serializer->pushSerializer(new ErrorSerializer());
$serializer->pushSerializer(new ResponseSerializer());

$transport = new HttpTransport($http, $http, $http, $serializer);
$client = ClientFactory::create($transport)->build();
```
