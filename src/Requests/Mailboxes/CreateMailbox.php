<?php

namespace Joehoel\Combell\Requests\Mailboxes;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * CreateMailbox
 */
class CreateMailbox extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/mailboxes";
	}


	public function __construct()
	{
	}
}
