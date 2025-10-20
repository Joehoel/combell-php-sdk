<?php

namespace Joehoel\Combell\Requests\MailZones;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * DeleteCatchAll
 */
class DeleteCatchAll extends Request
{
    protected Method $method = Method::DELETE;

    public function resolveEndpoint(): string
    {
        return "/mailzones/{$this->domainName}/catchall/{$this->emailAddress}";
    }

    /**
     * @param  string  $domainName  Mail zone domain name.
     * @param  string  $emailAddress  E-mail address to which all e-mails are sent to inexistent mailboxes or aliases.
     */
    public function __construct(
        protected string $domainName,
        protected string $emailAddress,
    ) {}
}
