<?php

namespace Joehoel\Combell\Requests\MailZones;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * DeleteAlias
 */
class DeleteAlias extends Request
{
	protected Method $method = Method::DELETE;


	public function resolveEndpoint(): string
	{
		return "/mailzones/{$this->domainName}/aliases/{$this->emailAddress}";
	}


	/**
	 * @param string $domainName Mail zone domain name.
	 * @param string $emailAddress Alias e-mail address.
	 */
	public function __construct(
		protected string $domainName,
		protected string $emailAddress,
	) {
	}
}
