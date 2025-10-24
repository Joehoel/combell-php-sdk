<?php

use Joehoel\Combell\Combell;
use Joehoel\Combell\Dto\LinuxHosting;
use Joehoel\Combell\Requests\LinuxHostings\GetLinuxHostings;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

it('maps GetLinuxHostings to LinuxHosting DTO list', function () {
    $mockClient = new MockClient([
        GetLinuxHostings::class => MockResponse::make(
            body: json_encode([
                ['domain_name' => 'example.com', 'servicepack_id' => 123],
                ['domain_name' => 'test.be', 'servicepack_id' => 456],
            ]),
            status: 200,
            headers: ['Content-Type' => 'application/json'],
        ),
    ]);

    $sdk = Combell::fake($mockClient);
    $response = $sdk->linuxHostings()->getLinuxHostings();

    /** @var LinuxHosting[] $hostings */
    $hostings = $response->dto();

    expect($hostings)->toBeArray();
    expect($hostings)->toHaveCount(2);
    expect($hostings[0])->toBeInstanceOf(LinuxHosting::class);
    expect($hostings[0]->domainName)->toBe('example.com');
    expect($hostings[0]->servicepackId)->toBe(123);
});
