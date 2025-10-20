<?php

namespace Joehoel\Combell\Requests\Mailboxes;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetMailboxes
 *
 * Currently only supports getting the mailboxes filtered by domain name.
 */
class GetMailboxes extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/mailboxes';
    }

    /**
     * @param  null|string  $domainName  Obligated domain name for getting mailboxes.
     */
    public function __construct(
        protected ?string $domainName = null,
    ) {}

    public function defaultQuery(): array
    {
        return array_filter(['domain_name' => $this->domainName]);
    }
}
