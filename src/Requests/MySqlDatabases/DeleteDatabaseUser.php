<?php

namespace Joehoel\Combell\Requests\MySqlDatabases;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * DeleteDatabaseUser
 *
 * The deletion of a mysql user is allowed for users with read_only rights.
 */
class DeleteDatabaseUser extends Request
{
	protected Method $method = Method::DELETE;


	public function resolveEndpoint(): string
	{
		return "/mysqldatabases/{$this->databaseName}/users/{$this->userName}";
	}


	/**
	 * @param string $databaseName Name of the database.
	 * @param string $userName Name of the user.
	 */
	public function __construct(
		protected string $databaseName,
		protected string $userName,
	) {
	}
}
