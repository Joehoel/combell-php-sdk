<?php

namespace Joehoel\Combell\Requests\Accounts;

use Joehoel\Combell\Dto\AccountDetail;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

/**
 * GetAccount
 */
class GetAccount extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/accounts/{$this->accountId}";
    }

    /**
     * @param  int  $accountId  The id of the account.
     */
    public function __construct(protected int $accountId) {}

    public function createDtoFromResponse(Response $response): AccountDetail
    {
        return AccountDetail::fromResponse($response->json());
    }
}
