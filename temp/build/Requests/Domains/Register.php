<?php

namespace Joehoel\Combell\Requests\Domains;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Register
 *
 * Registers an available domain.
 * Domain names with extension '.ca' are only available for registrants
 * with country code 'CA'.
 */
class Register extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/domains/registrations";
	}


	public function __construct()
	{
	}
}
