<?php

namespace Joehoel\Combell\Requests\LinuxHostings;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * ChangeAutoRedirect
 */
class ChangeAutoRedirect extends Request
{
    protected Method $method = Method::PUT;

    public function resolveEndpoint(): string
    {
        return "/linuxhostings/{$this->domainName}/sslsettings/{$this->hostname}/autoredirect";
    }

    /**
     * @param  string  $domainName  Linux hosting domain name.
     * @param  string  $hostname  Specific hostname.
     */
    public function __construct(
        protected string $domainName,
        protected string $hostname,
    ) {}
}
