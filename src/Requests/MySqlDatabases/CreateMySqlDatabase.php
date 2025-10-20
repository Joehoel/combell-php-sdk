<?php

namespace Joehoel\Combell\Requests\MySqlDatabases;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * CreateMySqlDatabase
 */
class CreateMySqlDatabase extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/mysqldatabases";
	}


	public function __construct()
	{
	}
}
