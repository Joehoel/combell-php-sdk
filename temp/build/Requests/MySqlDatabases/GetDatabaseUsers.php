<?php

namespace Joehoel\Combell\Requests\MySqlDatabases;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

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
	 * @param string $databaseName Name of the database.
	 */
	public function __construct(
		protected string $databaseName,
	) {
	}
}
