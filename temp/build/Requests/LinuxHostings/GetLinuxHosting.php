<?php

namespace Joehoel\Combell\Requests\LinuxHostings;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetLinuxHosting
 */
class GetLinuxHosting extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/linuxhostings/{$this->domainName}";
	}


	/**
	 * @param string $domainName The Linux hosting domain name.
	 */
	public function __construct(
		protected string $domainName,
	) {
	}
}
