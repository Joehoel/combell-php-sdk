<?php

namespace Joehoel\Combell\Requests\LinuxHostings;

use Joehoel\Combell\Concerns\MapsToDto;
use Joehoel\Combell\Dto\ScheduledTask;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetScheduledTask
 */
class GetScheduledTask extends Request
{
    use MapsToDto;

    protected Method $method = Method::GET;

    protected ?string $dtoClass = ScheduledTask::class;

    public function resolveEndpoint(): string
    {
        return "/linuxhostings/{$this->domainName}/scheduledtasks/{$this->scheduledTaskId}";
    }

    /**
     * @param  string  $domainName  Linux hosting domain name.
     * @param  string  $scheduledTaskId  Id of the scheduled task.
     */
    public function __construct(
        protected string $domainName,
        protected string $scheduledTaskId,
    ) {}
}
