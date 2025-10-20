<?php

namespace Joehoel\Combell\Requests\ProvisioningJobs;


use Joehoel\Combell\Dto\ProvisioningJobInfo;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

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

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/provisioningjobs/{$this->jobId}";
    }

    public function __construct(
        protected string $jobId,
    ) {}




    public function createDtoFromResponse(Response $response): ProvisioningJobInfo
    {
        return ProvisioningJobInfo::fromResponse($response->json());
    }

}
