<?php

namespace Joehoel\Combell\Requests\LinuxHostings;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetScheduledTask
 */
class GetScheduledTask extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/linuxhostings/{$this->domainName}/scheduledtasks/{$this->scheduledTaskId}";
	}


	/**
	 * @param string $domainName Linux hosting domain name.
	 * @param string $scheduledTaskId Id of the scheduled task.
	 */
	public function __construct(
		protected string $domainName,
		protected string $scheduledTaskId,
	) {
	}
}
