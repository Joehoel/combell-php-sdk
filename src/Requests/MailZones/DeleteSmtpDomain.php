<?php

namespace Joehoel\Combell\Requests\MailZones;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * DeleteSmtpDomain
 */
class DeleteSmtpDomain extends Request
{
    protected Method $method = Method::DELETE;

    public function resolveEndpoint(): string
    {
        return "/mailzones/{$this->domainName}/smtpdomains/{$this->hostname}";
    }

    /**
     * @param  string  $domainName  Mail zone domain name.
     * @param  string  $hostname  Smtp domain name.
     */
    public function __construct(
        protected string $domainName,
        protected string $hostname,
    ) {}
}
