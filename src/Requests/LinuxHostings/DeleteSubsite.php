<?php

namespace Joehoel\Combell\Requests\LinuxHostings;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * DeleteSubsite
 */
class DeleteSubsite extends Request
{
    protected Method $method = Method::DELETE;

    public function resolveEndpoint(): string
    {
        return "/linuxhostings/{$this->domainName}/subsites/{$this->siteName}";
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
