<?php

namespace Joehoel\Combell\Requests\LinuxHostings;

use Saloon\Enums\Method;
use Saloon\Http\Request;

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
}
