<?php

namespace Joehoel\Combell\Requests\MailZones;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * CreateSmtpDomain
 */
class CreateSmtpDomain extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return "/mailzones/{$this->domainName}/smtpdomains";
    }

    /**
     * @param  string  $domainName  Mail zone domain name.
     */
    public function __construct(
        protected string $domainName,
    ) {}
}
