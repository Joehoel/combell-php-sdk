<?php

namespace Joehoel\Combell\Requests\MySqlDatabases;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * DeleteDatabase
 */
class DeleteDatabase extends Request
{
	protected Method $method = Method::DELETE;


	public function resolveEndpoint(): string
	{
		return "/mysqldatabases/{$this->databaseName}";
	}


	/**
	 * @param string $databaseName Name of the database.
	 */
	public function __construct(
		protected string $databaseName,
	) {
	}
}
