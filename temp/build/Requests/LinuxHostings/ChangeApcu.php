<?php

namespace Joehoel\Combell\Requests\LinuxHostings;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * ChangeApcu
 */
class ChangeApcu extends Request
{
	protected Method $method = Method::PUT;


	public function resolveEndpoint(): string
	{
		return "/linuxhostings/{$this->domainName}/phpsettings/apcu";
	}


	/**
	 * @param string $domainName Linux hosting domain name
	 */
	public function __construct(
		protected string $domainName,
	) {
	}
}
