<?php

namespace Joehoel\Combell\Requests\LinuxHostings;

use Joehoel\Combell\Concerns\MapsToDto;
use Joehoel\Combell\Dto\ScheduledTask;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetScheduledTasks
 *
 * Manage scheduled tasks which are also manageable via the control panel.
 */
class GetScheduledTasks extends Request
{
    use MapsToDto;

    protected Method $method = Method::GET;

    protected ?string $dtoClass = ScheduledTask::class;

    protected bool $dtoIsList = true;

    protected ?string $dtoCollectionKey = null;

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
