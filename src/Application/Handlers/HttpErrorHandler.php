<?php
declare(strict_types=1);

namespace App\Application\Handlers;

use Psr\Http\Message\ResponseInterface as Response;
use Slim\Handlers\ErrorHandler as SlimErrorHandler;

class HttpErrorHandler extends SlimErrorHandler
{
    /**
     * @inheritdoc
     */
    protected function respond(): Response
    {
        $response = $this->responseFactory->createResponse(500);
        $response->getBody()->write(json_encode(['error' => $this->exception->getMessage()]));

        return $response->withHeader('Content-Type', 'application/json');
    }
}
