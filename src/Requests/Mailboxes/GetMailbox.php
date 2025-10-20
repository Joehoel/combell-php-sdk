<?php

namespace Joehoel\Combell\Requests\Mailboxes;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetMailbox
 */
class GetMailbox extends Request
{
    protected Method $method = Method::GET;

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
