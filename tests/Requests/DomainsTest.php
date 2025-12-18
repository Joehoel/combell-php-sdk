<?php

use Joehoel\Combell\Combell;
use Joehoel\Combell\Dto\Domain;
use Joehoel\Combell\Dto\DomainDetail;
use Joehoel\Combell\Requests\Domains\ConfigureDomain;
use Joehoel\Combell\Requests\Domains\EditNameServers;
use Joehoel\Combell\Requests\Domains\GetDomain;
use Joehoel\Combell\Requests\Domains\GetDomains;
use Joehoel\Combell\Requests\Domains\Register;
use Joehoel\Combell\Requests\Domains\Transfer;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\PendingRequest;

// ============================================================================
// GetDomains Tests
// ============================================================================

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

it('builds GET /domains with pagination query params', function () {
    $mock = new MockClient([
        GetDomains::class => function (PendingRequest $p) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe('/v2/domains');
            expect((string) $uri->getQuery())->toContain('skip=5');
            expect((string) $uri->getQuery())->toContain('take=50');

            return MockResponse::make('[]', 200, [
                'Content-Type' => 'application/json',
            ]);
        },
    ]);

    $sdk = Combell::fake($mock);
    $sdk->domains()->getDomains(skip: 5, take: 50);
});

// ============================================================================
// GetDomain Tests
// ============================================================================

it('builds GET /domains/{domainName}', function () {
    $domainName = 'example.com';

    $mock = new MockClient([
        GetDomain::class => function (PendingRequest $p) use ($domainName) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe("/v2/domains/{$domainName}");
            expect($p->getMethod()->value)->toBe('GET');

            return MockResponse::make('{}', 200, [
                'Content-Type' => 'application/json',
            ]);
        },
    ]);

    $sdk = Combell::fake($mock);
    $sdk->domains()->getDomain($domainName);
});

it('maps GetDomain to DomainDetail DTO', function () {
    $domainName = 'details.example';

    $mock = new MockClient([
        GetDomain::class => MockResponse::make(json_encode([
            'domain_name' => $domainName,
            'expiration_date' => '2025-06-01',
            'will_renew' => false,
            'name_servers' => ['ns1.example', 'ns2.example'],
            'registrant' => ['name' => 'Alice Registrant', 'country' => 'BE'],
            'can_toggle_renew' => true,
        ]), 200, ['Content-Type' => 'application/json']),
    ]);

    $sdk = Combell::fake($mock);
    $response = $sdk->domains()->getDomain($domainName);

    /** @var DomainDetail $detail */
    $detail = $response->dto();

    expect($detail)->toBeInstanceOf(DomainDetail::class);
    expect($detail->domainName)->toBe($domainName);
    expect($detail->nameServers)->toMatchArray(['ns1.example', 'ns2.example']);
    expect($detail->registrant)->not->toBeNull();
    expect($detail->registrant->name ?? null)->toBe('Alice Registrant');
});

// ============================================================================
// Register & Transfer Tests
// ============================================================================

it('builds POST /domains/registrations with JSON body', function () {
    $mock = new MockClient([
        Register::class => function (PendingRequest $p) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe('/v2/domains/registrations');
            expect($p->getMethod()->value)->toBe('POST');

            $body = $p->body()->all();
            expect($body)->toMatchArray([
                'domain_name' => 'new-domain.example',
                'period' => 1,
                'contacts' => ['registrant' => ['name' => 'Alice']],
            ]);

            return MockResponse::make('', 202, [
                'Content-Type' => 'application/json',
            ]);
        },
    ]);

    $sdk = Combell::fake($mock);
    $request = new Register;
    $request->body()->merge([
        'domain_name' => 'new-domain.example',
        'period' => 1,
        'contacts' => ['registrant' => ['name' => 'Alice']],
    ]);
    $response = $sdk->send($request);

    expect($response->status())->toBe(202);
});

it('builds POST /domains/transfers with JSON body', function () {
    $mock = new MockClient([
        Transfer::class => function (PendingRequest $p) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe('/v2/domains/transfers');
            expect($p->getMethod()->value)->toBe('POST');

            $body = $p->body()->all();
            expect($body)->toMatchArray([
                'domain_name' => 'transfer.example',
                'auth_code' => 'ABC-123',
            ]);

            return MockResponse::make('', 202, [
                'Content-Type' => 'application/json',
            ]);
        },
    ]);

    $sdk = Combell::fake($mock);
    $request = new Transfer;
    $request->body()->merge([
        'domain_name' => 'transfer.example',
        'auth_code' => 'ABC-123',
    ]);
    $response = $sdk->send($request);

    expect($response->status())->toBe(202);
});

// ============================================================================
// Domain Configuration Tests
// ============================================================================

it('builds PUT /domains/{domainName}/nameservers', function () {
    $domainName = 'example.com';

    $mock = new MockClient([
        EditNameServers::class => function (PendingRequest $p) use ($domainName) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe("/v2/domains/{$domainName}/nameservers");
            expect($p->getMethod()->value)->toBe('PUT');

            return MockResponse::make('', 200);
        },
    ]);

    $sdk = Combell::fake($mock);
    $response = $sdk->domains()->editNameServers($domainName);

    expect($response->status())->toBe(200);
});

it('builds PUT /domains/{domainName}/renew', function () {
    $domainName = 'example.com';

    $mock = new MockClient([
        ConfigureDomain::class => function (PendingRequest $p) use ($domainName) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe("/v2/domains/{$domainName}/renew");
            expect($p->getMethod()->value)->toBe('PUT');

            return MockResponse::make('', 200);
        },
    ]);

    $sdk = Combell::fake($mock);
    $response = $sdk->domains()->configureDomain($domainName);

    expect($response->status())->toBe(200);
});
