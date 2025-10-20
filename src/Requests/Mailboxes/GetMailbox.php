<?php

namespace Joehoel\Combell\Requests\Mailboxes;


use Joehoel\Combell\Dto\MailboxDetail;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

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




    public function createDtoFromResponse(Response $response): MailboxDetail
    {
        return MailboxDetail::fromResponse($response->json());
    }

}
