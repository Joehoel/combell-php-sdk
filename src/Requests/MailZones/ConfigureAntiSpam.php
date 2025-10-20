<?php

namespace Joehoel\Combell\Requests\MailZones;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * ConfigureAntiSpam
 */
class ConfigureAntiSpam extends Request
{
    protected Method $method = Method::PUT;

    public function resolveEndpoint(): string
    {
        return "/mailzones/{$this->domainName}/antispam";
    }

    /**
     * @param  string  $domainName  Mail zone domain name.
     */
    public function __construct(
        protected string $domainName,
    ) {}
}
