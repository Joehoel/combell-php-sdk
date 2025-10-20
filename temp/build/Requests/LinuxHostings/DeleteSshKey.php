<?php

namespace Joehoel\Combell\Requests\LinuxHostings;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * DeleteSshKey
 */
class DeleteSshKey extends Request
{
	protected Method $method = Method::DELETE;


	public function resolveEndpoint(): string
	{
		return "/linuxhostings/{$this->domainName}/ssh/keys/{$this->fingerprint}";
	}


	/**
	 * @param string $domainName Linux hosting domain name.
	 * @param string $fingerprint Fingerprint of public key.
	 */
	public function __construct(
		protected string $domainName,
		protected string $fingerprint,
	) {
	}
}
