<?php

namespace Joehoel\Combell\Requests\MySqlDatabases;

use Joehoel\Combell\Concerns\MapsToDto;
use Joehoel\Combell\Dto\MySqlUser;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetDatabaseUsers
 */
class GetDatabaseUsers extends Request
{
    use MapsToDto;

    protected Method $method = Method::GET;

    protected ?string $dtoClass = MySqlUser::class;

    protected bool $dtoIsList = true;

    protected ?string $dtoCollectionKey = null;

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
}
