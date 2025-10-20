<?php

namespace Joehoel\Combell\Requests\MySqlDatabases;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * ChangeDatabaseUserStatus
 */
class ChangeDatabaseUserStatus extends Request
{
    protected Method $method = Method::PUT;

    public function resolveEndpoint(): string
    {
        return "/mysqldatabases/{$this->databaseName}/users/{$this->userName}/status";
    }

    /**
     * @param  string  $databaseName  Name of the database.
     * @param  string  $userName  Name of the user.
     */
    public function __construct(
        protected string $databaseName,
        protected string $userName,
    ) {}
}
