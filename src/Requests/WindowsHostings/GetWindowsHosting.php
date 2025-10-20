<?php

namespace Joehoel\Combell\Requests\WindowsHostings;

use Joehoel\Combell\Concerns\MapsToDto;
use Joehoel\Combell\Dto\WindowsHostingDetail;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetWindowsHosting
 */
class GetWindowsHosting extends Request
{
    use MapsToDto;

    protected Method $method = Method::GET;

    protected ?string $dtoClass = WindowsHostingDetail::class;

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
}
