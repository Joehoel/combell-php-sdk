<?php

namespace Joehoel\Combell\Requests\Accounts;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetAccounts
 */
class GetAccounts extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/accounts';
    }

    /**
     * @param  null|int  $skip  The number of items to skip in the resultset.
     * @param  null|int  $take  The number of items to return in the resultset. The returned count can be equal or less than this number.
     * @param  null|string  $assetType  Filters the list, returning only accounts containing the specified asset type.
     * @param  null|string  $identifier  Return only accounts, matching the specified identifier.
     */
    public function __construct(
        protected ?int $skip = null,
        protected ?int $take = null,
        protected ?string $assetType = null,
        protected ?string $identifier = null,
    ) {}

    public function defaultQuery(): array
    {
        return array_filter(['skip' => $this->skip, 'take' => $this->take, 'asset_type' => $this->assetType, 'identifier' => $this->identifier]);
    }
}
