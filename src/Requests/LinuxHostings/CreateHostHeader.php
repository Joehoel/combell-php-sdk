<?php

namespace Joehoel\Combell\Requests\LinuxHostings;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * CreateHostHeader
 */
class CreateHostHeader extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return "/linuxhostings/{$this->domainName}/sites/{$this->siteName}/hostheaders";
    }

    /**
     * @param  string  $domainName  Linux hosting domain name.
     * @param  string  $siteName  Name of the site on the linux hosting.
     */
    public function __construct(
        protected string $domainName,
        protected string $siteName,
    ) {}
}
