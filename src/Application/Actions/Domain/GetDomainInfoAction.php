<?php
declare(strict_types=1);

namespace App\Application\Actions\Domain;

use hiqdev\rdap\core\Domain\ValueObject\DomainName;
use hiqdev\rdap\core\Infrastructure\Provider\DomainProviderInterface;
use hiqdev\rdap\core\Infrastructure\Serialization\SerializerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Psr7\Request;

final class GetDomainInfoAction
{
    /**
     * @var DomainProviderInterface
     */
    private $domainProvider;
    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(DomainProviderInterface $domainProvider, SerializerInterface $serializer)
    {
        $this->domainProvider = $domainProvider;
        $this->serializer = $serializer;
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        if (empty($args['domainName'])) {
            throw new \BadMethodCallException('Domain name is missing');
        }

        $domain = $this->domainProvider->get(DomainName::of($args['domainName']));

        return $response->withHeader('Content-Type', 'application/json')
            ->withStatus(200)
            ->withBody($this->serializer->serialize($domain));
    }
}
