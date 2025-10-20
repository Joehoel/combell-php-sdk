<?php

namespace Joehoel\Combell\Requests\LinuxHostings;


use Joehoel\Combell\Dto\LinuxHostingDetail;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

/**
 * GetLinuxHosting
 */
class GetLinuxHosting extends Request
{

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/linuxhostings/{$this->domainName}";
    }

    /**
     * @param  string  $domainName  The Linux hosting domain name.
     */
    public function __construct(
        protected string $domainName,
    ) {}




    public function createDtoFromResponse(Response $response): LinuxHostingDetail
    {
        return LinuxHostingDetail::fromResponse($response->json());
    }

}
