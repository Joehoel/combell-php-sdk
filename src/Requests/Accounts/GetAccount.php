<?php

namespace Joehoel\Combell\Requests\Accounts;

use Joehoel\Combell\Concerns\MapsToDto;
use Joehoel\Combell\Dto\AccountDetail;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetAccount
 */
class GetAccount extends Request
{
    use MapsToDto;

    protected Method $method = Method::GET;

    protected ?string $dtoClass = AccountDetail::class;

    public function resolveEndpoint(): string
    {
        return "/accounts/{$this->accountId}";
    }

    /**
     * @param  int  $accountId  The id of the account.
     */
    public function __construct(protected int $accountId) {}
}
