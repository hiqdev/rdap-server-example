<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

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
        \hiqdev\rdap\core\Infrastructure\Serialization\SerializerInterface::class
            => DI\autowire(\hiqdev\rdap\core\Infrastructure\Serialization\Symfony\SymfonySerializer::class),
        \hiqdev\rdap\core\Infrastructure\Provider\DomainProviderInterface::class
            => DI\autowire(\hiqdev\rdap\WhoisProxy\Provider\WhoisDomainProvider::class),
        \Iodev\Whois\Whois::class => function() { return \Iodev\Whois\Whois::create(); }
    ]);
};
