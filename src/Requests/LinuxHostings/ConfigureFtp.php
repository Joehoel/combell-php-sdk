<?php

namespace Joehoel\Combell\Requests\LinuxHostings;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * ConfigureFtp
 */
class ConfigureFtp extends Request
{
    protected Method $method = Method::PUT;

    public function resolveEndpoint(): string
    {
        return "/linuxhostings/{$this->domainName}/ftp/configuration";
    }

    /**
     * @param  string  $domainName  Linux hosting domain name.
     */
    public function __construct(
        protected string $domainName,
    ) {}
}
