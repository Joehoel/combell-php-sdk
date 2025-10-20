<?php

namespace Joehoel\Combell\Requests\WindowsHostings;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetWindowsHosting
 */
class GetWindowsHosting extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/windowshostings/{$this->domainName}";
	}


	/**
	 * @param string $domainName The Windows hosting domain name.
	 */
	public function __construct(
		protected string $domainName,
	) {
	}
}
