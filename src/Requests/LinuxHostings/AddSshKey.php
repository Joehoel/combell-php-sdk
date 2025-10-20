<?php

namespace Joehoel\Combell\Requests\LinuxHostings;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * AddSshKey
 */
class AddSshKey extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/linuxhostings/{$this->domainName}/ssh/keys";
	}


	/**
	 * @param string $domainName Linux hosting domain name.
	 */
	public function __construct(
		protected string $domainName,
	) {
	}
}
