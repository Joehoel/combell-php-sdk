<?php

namespace Joehoel\Combell\Requests\LinuxHostings;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * ChangeLetsEncrypt
 */
class ChangeLetsEncrypt extends Request
{
	protected Method $method = Method::PUT;


	public function resolveEndpoint(): string
	{
		return "/linuxhostings/{$this->domainName}/sslsettings/{$this->hostname}/letsencrypt";
	}


	/**
	 * @param string $domainName Linux hosting domain name.
	 * @param string $hostname Specific hostname.
	 */
	public function __construct(
		protected string $domainName,
		protected string $hostname,
	) {
	}
}
