<?php

namespace Joehoel\Combell\Requests\LinuxHostings;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetScheduledTasks
 *
 * Manage scheduled tasks which are also manageable via the control panel.
 */
class GetScheduledTasks extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/linuxhostings/{$this->domainName}/scheduledtasks";
    }

    /**
     * @param  string  $domainName  Linux hosting domain name.
     */
    public function __construct(
        protected string $domainName,
    ) {}
}
