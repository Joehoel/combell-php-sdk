<?php

namespace Joehoel\Combell\Requests\Domains;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetDomain
 */
class GetDomain extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/domains/{$this->domainName}";
	}


	/**
	 * @param string $domainName The domain name
	 */
	public function __construct(
		protected string $domainName,
	) {
	}
}
