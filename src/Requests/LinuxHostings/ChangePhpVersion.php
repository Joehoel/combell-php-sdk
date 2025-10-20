<?php

namespace Joehoel\Combell\Requests\LinuxHostings;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * ChangePhpVersion
 */
class ChangePhpVersion extends Request
{
    protected Method $method = Method::PUT;

    public function resolveEndpoint(): string
    {
        return "/linuxhostings/{$this->domainName}/phpsettings/version";
    }

    /**
     * @param  string  $domainName  Linux hosting domain name.
     */
    public function __construct(
        protected string $domainName,
    ) {}
}
