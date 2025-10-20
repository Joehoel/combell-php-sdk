<?php

namespace Joehoel\Combell\Requests\LinuxHostings;


use Joehoel\Combell\Dto\PhpVersion;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

/**
 * GetAvailablePhpVersions
 */
class GetAvailablePhpVersions extends Request
{

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/linuxhostings/{$this->domainName}/phpsettings/availableversions";
    }

    /**
     * @param  string  $domainName  Linux hosting domain name.
     */
    public function __construct(
        protected string $domainName,
    ) {}




    public function createDtoFromResponse(Response $response): array
    {
        return PhpVersion::collect($response->json());
    }

}
