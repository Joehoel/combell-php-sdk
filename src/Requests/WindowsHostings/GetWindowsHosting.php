<?php

namespace Joehoel\Combell\Requests\WindowsHostings;

use Joehoel\Combell\Dto\WindowsHostingDetail;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

/**
 * GetWindowsHosting
 */
class GetWindowsHosting extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/windowshostings/{$this->domainName}";
    }

    /**
     * @param  string  $domainName  The Windows hosting domain name.
     */
    public function __construct(
        protected string $domainName,
    ) {}

    public function createDtoFromResponse(Response $response): WindowsHostingDetail
    {
        return WindowsHostingDetail::fromResponse($response->json());
    }
}
