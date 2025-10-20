<?php

namespace Joehoel\Combell\Requests\MailZones;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * CreateAlias
 */
class CreateAlias extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/mailzones/{$this->domainName}/aliases";
	}


	/**
	 * @param string $domainName Mail zone domain name.
	 */
	public function __construct(
		protected string $domainName,
	) {
	}
}
