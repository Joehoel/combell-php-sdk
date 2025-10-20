<?php

namespace Joehoel\Combell\Requests\MySqlDatabases;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

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


	/**
	 * @param string $databaseName
	 */
	public function __construct(
		protected string $databaseName,
	) {
	}
}
