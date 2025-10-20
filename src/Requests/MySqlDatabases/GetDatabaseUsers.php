<?php

namespace Joehoel\Combell\Requests\MySqlDatabases;

use Joehoel\Combell\Dto\MySqlUser;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

/**
 * GetDatabaseUsers
 */
class GetDatabaseUsers extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/mysqldatabases/{$this->databaseName}/users";
    }

    /**
     * @param  string  $databaseName  Name of the database.
     */
    public function __construct(
        protected string $databaseName,
    ) {}

    public function createDtoFromResponse(Response $response): array
    {
        return MySqlUser::collect($response->json());
    }
}
