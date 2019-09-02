<?php
/** @noinspection UnusedFunctionResultInspection */
declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $container = $app->getContainer();

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->group('/domain', function (Group $group) use ($container) {
        $group->get('/{domainName}', \App\Application\Actions\Domain\GetDomainInfoAction::class);
    });
};
