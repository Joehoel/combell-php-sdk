<?php

namespace Joehoel\Combell\Requests\Mailboxes;

use Joehoel\Combell\Concerns\MapsToDto;
use Joehoel\Combell\Dto\Mailbox;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetMailboxes
 *
 * Currently only supports getting the mailboxes filtered by domain name.
 */
class GetMailboxes extends Request
{
    use MapsToDto;

    protected Method $method = Method::GET;

    protected ?string $dtoClass = Mailbox::class;

    protected bool $dtoIsList = true;

    protected ?string $dtoCollectionKey = null;

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
