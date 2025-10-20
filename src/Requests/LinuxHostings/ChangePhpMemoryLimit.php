<?php

namespace Joehoel\Combell\Requests\LinuxHostings;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * ChangePhpMemoryLimit
 */
class ChangePhpMemoryLimit extends Request
{
    protected Method $method = Method::PUT;

    public function resolveEndpoint(): string
    {
        return "/linuxhostings/{$this->domainName}/phpsettings/memorylimit";
    }

    /**
     * @param  string  $domainName  Linux hosting domain name.
     */
    public function __construct(
        protected string $domainName,
    ) {}
}
