<?php

namespace Joehoel\Combell\Requests\MySqlDatabases;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * ChangeDatabaseUserPassword
 */
class ChangeDatabaseUserPassword extends Request
{
	protected Method $method = Method::PUT;


	public function resolveEndpoint(): string
	{
		return "/mysqldatabases/{$this->databaseName}/users/{$this->userName}/password";
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
