<?php

namespace Joehoel\Combell\Requests\LinuxHostings;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * ChangeGzipCompression
 */
class ChangeGzipCompression extends Request
{
	protected Method $method = Method::PUT;


	public function resolveEndpoint(): string
	{
		return "/linuxhostings/{$this->domainName}/settings/gzipcompression";
	}


	/**
	 * @param string $domainName Linux hosting domain name
	 */
	public function __construct(
		protected string $domainName,
	) {
	}
}
