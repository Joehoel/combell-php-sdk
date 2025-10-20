<?php

namespace Joehoel\Combell\Resource;

use Joehoel\Combell\Requests\ProvisioningJobs\GetProvisioningJob;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

class ProvisioningJobs extends BaseResource
{
    public function getProvisioningJob(string $jobId): Response
    {
        return $this->connector->send(new GetProvisioningJob($jobId));
    }
}
