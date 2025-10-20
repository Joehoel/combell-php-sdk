<?php

namespace Joehoel\Combell\Requests\ProvisioningJobs;

use Joehoel\Combell\Concerns\MapsToDto;
use Joehoel\Combell\Dto\ProvisioningJobInfo;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetProvisioningJob
 *
 * Provisioning failures may occur. Contact support in the event of a failure or wait for error
 * resolution.
 *
 * Do NOT retry provisioning until the job reports finished or cancelled.
 */
class GetProvisioningJob extends Request
{
    use MapsToDto;

    protected Method $method = Method::GET;

    protected ?string $dtoClass = ProvisioningJobInfo::class;

    public function resolveEndpoint(): string
    {
        return "/provisioningjobs/{$this->jobId}";
    }

    public function __construct(
        protected string $jobId,
    ) {}
}
