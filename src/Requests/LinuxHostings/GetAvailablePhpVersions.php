<?php

namespace Joehoel\Combell\Requests\LinuxHostings;

use Joehoel\Combell\Concerns\MapsToDto;
use Joehoel\Combell\Dto\PhpVersion;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetAvailablePhpVersions
 */
class GetAvailablePhpVersions extends Request
{
    use MapsToDto;

    protected Method $method = Method::GET;

    protected ?string $dtoClass = PhpVersion::class;

    protected bool $dtoIsList = true;

    protected ?string $dtoCollectionKey = null;

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
}
