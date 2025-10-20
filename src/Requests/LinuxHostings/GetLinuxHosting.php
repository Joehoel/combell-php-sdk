<?php

namespace Joehoel\Combell\Requests\LinuxHostings;

use Joehoel\Combell\Concerns\MapsToDto;
use Joehoel\Combell\Dto\LinuxHostingDetail;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetLinuxHosting
 */
class GetLinuxHosting extends Request
{
    use MapsToDto;

    protected Method $method = Method::GET;

    protected ?string $dtoClass = LinuxHostingDetail::class;

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
}
