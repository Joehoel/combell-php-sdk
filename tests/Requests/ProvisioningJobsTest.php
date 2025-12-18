<?php

use Joehoel\Combell\Combell;
use Joehoel\Combell\Dto\ProvisioningJobInfo;
use Joehoel\Combell\Requests\ProvisioningJobs\GetProvisioningJob;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\PendingRequest;

it('builds GET /provisioningjobs/{jobId}', function () {
    $jobId = 'job-123';

    $mock = new MockClient([
        GetProvisioningJob::class => function (PendingRequest $p) use ($jobId) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe("/v2/provisioningjobs/{$jobId}");
            expect($p->getMethod()->value)->toBe('GET');

            return MockResponse::make('{}', 200, [
                'Content-Type' => 'application/json',
            ]);
        },
    ]);

    $sdk = Combell::fake($mock, 'key', 'secret');
    $sdk->provisioningJobs()->getProvisioningJob($jobId);
});

it('maps GetProvisioningJob to ProvisioningJobInfo DTO', function () {
    $jobId = 'job-xyz';
    $mockData = [
        'id' => $jobId,
        'status' => 'finished',
        'completion' => [
            'timestamp' => '2024-01-01T12:00:00Z',
            'code' => 'SUCCESS',
        ],
    ];

    $mock = new MockClient([
        GetProvisioningJob::class => MockResponse::make(json_encode($mockData), 200, [
            'Content-Type' => 'application/json',
        ]),
    ]);

    $sdk = Combell::fake($mock, 'key', 'secret');
    $response = $sdk->provisioningJobs()->getProvisioningJob($jobId);

    /** @var ProvisioningJobInfo $info */
    $info = $response->dto();

    expect($info)->toBeInstanceOf(ProvisioningJobInfo::class);
    expect($info->id)->toBe($jobId);
    expect($info->status)->toBe('finished');
    expect($info->completion)->not->toBeNull();
    expect($info->completion->code ?? null)->toBe('SUCCESS');
});
