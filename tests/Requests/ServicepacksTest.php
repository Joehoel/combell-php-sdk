<?php

use Joehoel\Combell\Combell;
use Joehoel\Combell\Dto\Servicepack;
use Joehoel\Combell\Requests\Servicepacks\Servicepacks as ServicepacksRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\PendingRequest;

it('builds GET /servicepacks', function () {
    $mock = new MockClient([
        ServicepacksRequest::class => function (PendingRequest $p) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe('/v2/servicepacks');
            expect($p->getMethod()->value)->toBe('GET');

            return MockResponse::make('[]', 200, [
                'Content-Type' => 'application/json',
            ]);
        },
    ]);

    $sdk = Combell::fake($mock, 'key', 'secret');
    $sdk->servicepacks()->servicepacks();
});

it('maps Servicepacks request to Servicepack DTO list', function () {
    $mockData = [
        ['id' => 1, 'name' => 'Starter'],
        ['id' => 2, 'name' => 'Pro'],
    ];

    $mock = new MockClient([
        ServicepacksRequest::class => MockResponse::make(json_encode($mockData), 200, [
            'Content-Type' => 'application/json',
        ]),
    ]);

    $sdk = Combell::fake($mock, 'key', 'secret');
    $response = $sdk->servicepacks()->servicepacks();

    /** @var Servicepack[] $servicepacks */
    $servicepacks = $response->dto();

    expect($servicepacks)->toBeArray();
    expect($servicepacks)->toHaveCount(2);
    expect($servicepacks[0])->toBeInstanceOf(Servicepack::class);
    expect($servicepacks[0]->name)->toBe('Starter');
    expect($servicepacks[1]->id)->toBe(2);
});
