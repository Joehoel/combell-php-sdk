<?php

namespace Joehoel\Combell\Requests\Domains;

use Joehoel\Combell\Concerns\MapsToDto;
use Joehoel\Combell\Dto\DomainDetail;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetDomain
 */
class GetDomain extends Request
{
    use MapsToDto;

    protected Method $method = Method::GET;

    protected ?string $dtoClass = DomainDetail::class;

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
}
