<?php

namespace Joehoel\Combell\Requests\MailZones;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetMailZone
 */
class GetMailZone extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/mailzones/{$this->domainName}";
    }

    /**
     * @param  string  $domainName  Mail zone domain name.
     */
    public function __construct(
        protected string $domainName,
    ) {}
}
