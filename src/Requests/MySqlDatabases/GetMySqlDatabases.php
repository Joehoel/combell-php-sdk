<?php

namespace Joehoel\Combell\Requests\MySqlDatabases;


use Joehoel\Combell\Dto\MySqlDatabase;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

/**
 * GetMySqlDatabases
 */
class GetMySqlDatabases extends Request
{

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/mysqldatabases';
    }

    /**
     * @param  null|int  $skip  The number of items to skip in the resultset.
     * @param  null|int  $take  The number of items to return in the resultset. The returned count can be equal or less than this number.
     */
    public function __construct(
        protected ?int $skip = null,
        protected ?int $take = null,
    ) {}

    public function defaultQuery(): array
    {
        return array_filter(['skip' => $this->skip, 'take' => $this->take]);
    }




    public function createDtoFromResponse(Response $response): array
    {
        return MySqlDatabase::collect($response->json('items'));
    }

}
