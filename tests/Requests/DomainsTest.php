<?php

use Joehoel\Combell\Combell;
use Joehoel\Combell\Dto\Domain;
use Joehoel\Combell\Requests\Domains\GetDomains;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

it('maps GetDomains to Domain DTO list', function () {
    $mockClient = new MockClient([
        GetDomains::class => MockResponse::make(
            body: json_encode([
                ['domain_name' => 'example.com', 'expiration_date' => '2025-01-01', 'will_renew' => true],
                ['domain_name' => 'test.be', 'expiration_date' => '2024-12-31', 'will_renew' => false],
            ]),
            status: 200,
            headers: ['Content-Type' => 'application/json'],
        ),
    ]);

    $sdk = Combell::fake($mockClient);
    $response = $sdk->domains()->getDomains();

    /** @var Domain[] $domains */
    $domains = $response->dto();

    expect($domains)->toBeArray();
    expect($domains)->toHaveCount(2);
    expect($domains[0])->toBeInstanceOf(Domain::class);
    expect($domains[0]->domainName)->toBe('example.com');
    expect($domains[0]->willRenew)->toBe(true);
});
