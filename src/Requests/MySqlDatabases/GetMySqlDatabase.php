<?php

namespace Joehoel\Combell\Requests\MySqlDatabases;

use Joehoel\Combell\Concerns\MapsToDto;
use Joehoel\Combell\Dto\MySqlDatabase;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetMySqlDatabase
 */
class GetMySqlDatabase extends Request
{
    use MapsToDto;

    protected Method $method = Method::GET;

    protected ?string $dtoClass = MySqlDatabase::class;

    public function resolveEndpoint(): string
    {
        return "/mysqldatabases/{$this->databaseName}";
    }

    public function __construct(
        protected string $databaseName,
    ) {}
}
