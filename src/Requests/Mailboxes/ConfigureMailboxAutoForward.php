<?php

namespace Joehoel\Combell\Requests\Mailboxes;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * ConfigureMailboxAutoForward
 */
class ConfigureMailboxAutoForward extends Request
{
    protected Method $method = Method::PUT;

    public function resolveEndpoint(): string
    {
        return "/mailboxes/{$this->mailboxName}/autoforward";
    }

    /**
     * @param  string  $mailboxName  Mailbox name.
     */
    public function __construct(
        protected string $mailboxName,
    ) {}
}
