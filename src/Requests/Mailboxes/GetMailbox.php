<?php

namespace Joehoel\Combell\Requests\Mailboxes;

use Joehoel\Combell\Concerns\MapsToDto;
use Joehoel\Combell\Dto\MailboxDetail;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetMailbox
 */
class GetMailbox extends Request
{
    use MapsToDto;

    protected Method $method = Method::GET;

    protected ?string $dtoClass = MailboxDetail::class;

    public function resolveEndpoint(): string
    {
        return "/mailboxes/{$this->mailboxName}";
    }

    /**
     * @param  string  $mailboxName  Mailbox name.
     */
    public function __construct(
        protected string $mailboxName,
    ) {}
}
