<?php

namespace Joehoel\Combell\Requests\Domains;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * EditNameServers
 */
class EditNameServers extends Request
{
	protected Method $method = Method::PUT;


	public function resolveEndpoint(): string
	{
		return "/domains/{$this->domainName}/nameservers";
	}


	/**
	 * @param string $domainName The domain name
	 */
	public function __construct(
		protected string $domainName,
	) {
	}
}
