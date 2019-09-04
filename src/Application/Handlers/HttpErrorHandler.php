<?php
declare(strict_types=1);

namespace App\Application\Handlers;

use Psr\Http\Message\ResponseInterface as Response;
use Slim\Handlers\ErrorHandler as SlimErrorHandler;

/**
 * @noinspection ContractViolationInspection
 */
class HttpErrorHandler extends SlimErrorHandler
{
    /**
     * @param bool $displayErrorDetails
     */
    public function setDisplayErrorDetailsFlag(bool $displayErrorDetails): void
    {
        $this->displayErrorDetails = $displayErrorDetails;
    }

    /**
     * @inheritdoc
     */
    protected function respond(): Response
    {
        $response = $this->responseFactory->createResponse(500);
        $response->getBody()->write(json_encode(array_filter([
            'error' => $this->exception->getMessage(),
            'trace' => $this->displayErrorDetails ? $this->exception->getTrace() : null,
        ])));

        return $response->withHeader('Content-Type', 'application/json');
    }
}
