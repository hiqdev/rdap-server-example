<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use hiqdev\rdap\core\Infrastructure\Provider\DomainProviderInterface;
use hiqdev\rdap\core\Infrastructure\Serialization\SerializerInterface;
use hiqdev\rdap\core\Infrastructure\Serialization\Symfony\SymfonySerializer;
use hiqdev\rdap\WhoisProxy\Provider\WhoisDomainProvider;
use Iodev\Whois\Whois;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Log\LoggerInterface;
use Slim\Psr7\Factory\StreamFactory;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get('settings');

            $loggerSettings = $settings['logger'];
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },
        SerializerInterface::class => DI\autowire(SymfonySerializer::class),
        DomainProviderInterface::class => DI\autowire(WhoisDomainProvider::class),
        StreamFactoryInterface::class => DI\autowire(StreamFactory::class),
        Whois::class => function () { return Whois::create(); }
    ]);
};
