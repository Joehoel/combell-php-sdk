<?php

namespace Joehoel\Combell\Requests\Domains;

use Joehoel\Combell\Dto\DomainDetail;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

/**
 * GetDomain
 */
class GetDomain extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/domains/{$this->domainName}";
    }

    /**
     * @param  string  $domainName  The domain name
     */
    public function __construct(
        protected string $domainName,
    ) {}

    public function createDtoFromResponse(Response $response): DomainDetail
    {
        return DomainDetail::fromResponse($response->json());
    }
}
