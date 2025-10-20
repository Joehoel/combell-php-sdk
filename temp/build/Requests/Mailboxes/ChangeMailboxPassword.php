<?php

namespace Joehoel\Combell\Requests\Mailboxes;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * ChangeMailboxPassword
 */
class ChangeMailboxPassword extends Request
{
	protected Method $method = Method::PUT;


	public function resolveEndpoint(): string
	{
		return "/mailboxes/{$this->mailboxName}/password";
	}


	/**
	 * @param string $mailboxName Mailbox name.
	 */
	public function __construct(
		protected string $mailboxName,
	) {
	}
}
