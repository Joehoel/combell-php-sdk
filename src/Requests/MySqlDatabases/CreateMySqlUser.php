<?php

namespace Joehoel\Combell\Requests\MySqlDatabases;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * CreateMySqlUser
 *
 * The creation of a new mysql user will result in a user with read_only rights.
 */
class CreateMySqlUser extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

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
