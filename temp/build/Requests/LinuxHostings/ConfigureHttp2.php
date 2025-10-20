<?php

namespace Joehoel\Combell\Requests\LinuxHostings;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * ConfigureHttp2
 */
class ConfigureHttp2 extends Request
{
	protected Method $method = Method::PUT;


	public function resolveEndpoint(): string
	{
		return "/linuxhostings/{$this->domainName}/sites/{$this->siteName}/http2/configuration";
	}


	/**
	 * @param string $domainName Linux hosting domain name.
	 * @param string $siteName Site name where HTTP/2 should be configured.
	 *
	 * For HTTP/2 to work correctly, the site must have ssl enabled.
	 */
	public function __construct(
		protected string $domainName,
		protected string $siteName,
	) {
	}
}
