<?php

namespace Joehoel\Combell\Requests\MySqlDatabases;


use Joehoel\Combell\Dto\MySqlDatabase;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

/**
 * GetMySqlDatabase
 */
class GetMySqlDatabase extends Request
{

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/mysqldatabases/{$this->databaseName}";
    }

    public function __construct(
        protected string $databaseName,
    ) {}




    public function createDtoFromResponse(Response $response): MySqlDatabase
    {
        return MySqlDatabase::fromResponse($response->json());
    }

}
