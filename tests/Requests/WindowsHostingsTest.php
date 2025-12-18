<?php

use Joehoel\Combell\Combell;
use Joehoel\Combell\Dto\WindowsHosting;
use Joehoel\Combell\Dto\WindowsHostingDetail;
use Joehoel\Combell\Requests\WindowsHostings\GetWindowsHosting;
use Joehoel\Combell\Requests\WindowsHostings\GetWindowsHostings;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\PendingRequest;

// ============================================================================
// GetWindowsHostings Tests
// ============================================================================

it('builds GET /windowshostings with no query by default', function () {
    $mock = new MockClient([
        GetWindowsHostings::class => function (PendingRequest $p) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe('/v2/windowshostings');
            expect((string) $uri->getQuery())->toBe('');
            expect($p->getMethod()->value)->toBe('GET');

            return MockResponse::make('[]', 200, [
                'Content-Type' => 'application/json',
            ]);
        },
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $sdk->windowsHostings()->getWindowsHostings();
});

it('builds GET /windowshostings with skip and take query params', function () {
    $mock = new MockClient([
        GetWindowsHostings::class => function (PendingRequest $p) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe('/v2/windowshostings');
            expect((string) $uri->getQuery())->toContain('skip=5');
            expect((string) $uri->getQuery())->toContain('take=15');

            return MockResponse::make('[]', 200, [
                'Content-Type' => 'application/json',
            ]);
        },
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $sdk->windowsHostings()->getWindowsHostings(skip: 5, take: 15);
});

it('maps GetWindowsHostings to WindowsHosting DTO list', function () {
    $mockData = [
        ['domain_name' => 'one.example.com', 'servicepack_id' => 101],
        ['domain_name' => 'two.example.com', 'servicepack_id' => 202],
    ];

    $mock = new MockClient([
        GetWindowsHostings::class => MockResponse::make(json_encode($mockData), 200, [
            'Content-Type' => 'application/json',
        ]),
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $response = $sdk->windowsHostings()->getWindowsHostings();

    /** @var WindowsHosting[] $hostings */
    $hostings = $response->dto();

    expect($hostings)->toBeArray();
    expect($hostings)->toHaveCount(2);
    expect($hostings[0])->toBeInstanceOf(WindowsHosting::class);
    expect($hostings[0]->domainName)->toBe('one.example.com');
    expect($hostings[0]->servicepackId)->toBe(101);
    expect($hostings[1]->domainName)->toBe('two.example.com');
});

// ============================================================================
// GetWindowsHosting Tests
// ============================================================================

it('builds GET /windowshostings/{domainName}', function () {
    $domainName = 'site.example.com';

    $mock = new MockClient([
        GetWindowsHosting::class => function (PendingRequest $p) use ($domainName) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe("/v2/windowshostings/{$domainName}");
            expect($p->getMethod()->value)->toBe('GET');

            return MockResponse::make('{}', 200, [
                'Content-Type' => 'application/json',
            ]);
        },
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $sdk->windowsHostings()->getWindowsHosting($domainName);
});

it('maps GetWindowsHosting to WindowsHostingDetail DTO', function () {
    $mockData = [
        'domain_name' => 'site.example.com',
        'servicepack_id' => 500,
        'max_size' => 1073741824,
        'actual_size' => 536870912,
        'ip' => '192.0.2.10',
        'ip_type' => 'IPv4',
        'ftp_username' => 'ftp-user',
        'application_pool' => ['name' => 'AppPool1', 'pipeline_mode' => 'integrated'],
        'sites' => [
            ['hostname' => 'site.example.com', 'ssl' => true],
            ['hostname' => 'admin.site.example.com', 'ssl' => false],
        ],
        'mssql_database_names' => ['db1', 'db2'],
    ];

    $mock = new MockClient([
        GetWindowsHosting::class => MockResponse::make(json_encode($mockData), 200, [
            'Content-Type' => 'application/json',
        ]),
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $response = $sdk->windowsHostings()->getWindowsHosting('site.example.com');

    /** @var WindowsHostingDetail $hosting */
    $hosting = $response->dto();

    expect($hosting)->toBeInstanceOf(WindowsHostingDetail::class);
    expect($hosting->domainName)->toBe('site.example.com');
    expect($hosting->servicepackId)->toBe(500);
    expect($hosting->maxSize)->toBe(1073741824);
    expect($hosting->actualSize)->toBe(536870912);
    expect($hosting->ip)->toBe('192.0.2.10');
    expect($hosting->ipType)->toBe('IPv4');
    expect($hosting->ftpUsername)->toBe('ftp-user');
    expect($hosting->applicationPool)->not->toBeNull();
    expect($hosting->sites)->toHaveCount(2);
    expect($hosting->mssqlDatabaseNames)->toMatchArray(['db1', 'db2']);
});

// ============================================================================
// Edge Cases
// ============================================================================

it('handles empty windows hosting list', function () {
    $mock = new MockClient([
        GetWindowsHostings::class => MockResponse::make('[]', 200, [
            'Content-Type' => 'application/json',
        ]),
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $response = $sdk->windowsHostings()->getWindowsHostings();

    $hostings = $response->dto();

    expect($hostings)->toBeArray();
    expect($hostings)->toHaveCount(0);
});

it('handles domain names with uppercase letters', function () {
    $domainName = 'Example.COM';

    $mock = new MockClient([
        GetWindowsHosting::class => function (PendingRequest $p) use ($domainName) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe('/v2/windowshostings/'.$domainName);

            return MockResponse::make('{}', 200, [
                'Content-Type' => 'application/json',
            ]);
        },
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $sdk->windowsHostings()->getWindowsHosting($domainName);
});
