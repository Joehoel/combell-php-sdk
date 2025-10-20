<?php

namespace Joehoel\Combell\Resource;

use Joehoel\Combell\Requests\Accounts\CreateAccount;
use Joehoel\Combell\Requests\Accounts\GetAccount;
use Joehoel\Combell\Requests\Accounts\GetAccounts;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

class Accounts extends BaseResource
{
    /**
     * @param  int  $skip  The number of items to skip in the resultset.
     * @param  int  $take  The number of items to return in the resultset. The returned count can be equal or less than this number.
     * @param  string  $assetType  Filters the list, returning only accounts containing the specified asset type.
     * @param  string  $identifier  Return only accounts, matching the specified identifier.
     */
    public function getAccounts(
        ?int $skip = null,
        ?int $take = null,
        ?string $assetType = null,
        ?string $identifier = null,
    ): Response {
        return $this->connector->send(
            new GetAccounts($skip, $take, $assetType, $identifier),
        );
    }

    public function createAccount(): Response
    {
        return $this->connector->send(new CreateAccount);
    }

    /**
     * @param  int  $accountId  The id of the account.
     */
    public function getAccount(int $accountId): Response
    {
        return $this->connector->send(new GetAccount($accountId));
    }
}
