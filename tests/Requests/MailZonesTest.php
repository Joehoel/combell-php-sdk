<?php

use Joehoel\Combell\Combell;
use Joehoel\Combell\Dto\MailZone;
use Joehoel\Combell\Requests\MailZones\ConfigureAlias;
use Joehoel\Combell\Requests\MailZones\ConfigureAntiSpam;
use Joehoel\Combell\Requests\MailZones\ConfigureSmtpDomain;
use Joehoel\Combell\Requests\MailZones\CreateAlias;
use Joehoel\Combell\Requests\MailZones\CreateCatchAll;
use Joehoel\Combell\Requests\MailZones\CreateSmtpDomain;
use Joehoel\Combell\Requests\MailZones\DeleteAlias;
use Joehoel\Combell\Requests\MailZones\DeleteCatchAll;
use Joehoel\Combell\Requests\MailZones\DeleteSmtpDomain;
use Joehoel\Combell\Requests\MailZones\GetMailZone;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\PendingRequest;

// ============================================================================
// GetMailZone Tests
// ============================================================================

it('builds GET /mailzones/{domainName}', function () {
    $domainName = 'example.com';

    $mock = new MockClient([
        GetMailZone::class => function (PendingRequest $p) use ($domainName) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe("/v2/mailzones/{$domainName}");
            expect($p->getMethod()->value)->toBe('GET');

            return MockResponse::make('{}', 200, [
                'Content-Type' => 'application/json',
            ]);
        },
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $sdk->mailZones()->getMailZone($domainName);
});

it('maps GetMailZone to MailZone DTO', function () {
    $mockData = [
        'name' => 'example.com',
        'enabled' => true,
        'available_accounts' => [
            ['account_id' => 1, 'size' => 1000],
            ['account_id' => 2, 'size' => 2000],
        ],
        'aliases' => [
            ['email_address' => 'alias@example.com', 'destinations' => ['dest@example.com']],
        ],
        'anti_spam' => [
            'type' => 'standard',
            'allowed_types' => ['standard', 'advanced'],
        ],
        'catch_all' => [
            'email_addresses' => ['catchall@example.com'],
        ],
        'smtp_domains' => [
            ['hostname' => 'smtp.example.com', 'enabled' => true],
        ],
    ];

    $mock = new MockClient([
        GetMailZone::class => MockResponse::make(json_encode($mockData), 200, [
            'Content-Type' => 'application/json',
        ]),
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $response = $sdk->mailZones()->getMailZone('example.com');

    /** @var MailZone $mailZone */
    $mailZone = $response->dto();

    expect($mailZone)->toBeInstanceOf(MailZone::class);
    expect($mailZone->name)->toBe('example.com');
    expect($mailZone->enabled)->toBe(true);
    expect($mailZone->availableAccounts)->toHaveCount(2);
    expect($mailZone->aliases)->toHaveCount(1);
    expect($mailZone->antiSpam)->not->toBeNull();
    expect($mailZone->catchAll)->not->toBeNull();
    expect($mailZone->smtpDomains)->toHaveCount(1);
});

// ============================================================================
// CreateCatchAll Tests
// ============================================================================

it('builds POST /mailzones/{domainName}/catchall with JSON body', function () {
    $domainName = 'example.com';

    $mock = new MockClient([
        CreateCatchAll::class => function (PendingRequest $p) use ($domainName) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe("/v2/mailzones/{$domainName}/catchall");
            expect($p->getMethod()->value)->toBe('POST');

            $body = $p->body()->all();
            expect($body)->toMatchArray([
                'email_address' => 'catchall@example.com',
            ]);

            return MockResponse::make('', 201, [
                'Content-Type' => 'application/json',
            ]);
        },
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $request = new CreateCatchAll($domainName);
    $request->body()->merge([
        'email_address' => 'catchall@example.com',
    ]);
    $response = $sdk->send($request);

    expect($response->status())->toBe(201);
});

// ============================================================================
// DeleteCatchAll Tests
// ============================================================================

it('builds DELETE /mailzones/{domainName}/catchall/{emailAddress}', function () {
    $domainName = 'example.com';
    $emailAddress = 'catchall@example.com';

    $mock = new MockClient([
        DeleteCatchAll::class => function (PendingRequest $p) use ($domainName, $emailAddress) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe("/v2/mailzones/{$domainName}/catchall/{$emailAddress}");
            expect($p->getMethod()->value)->toBe('DELETE');

            return MockResponse::make('', 204);
        },
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $response = $sdk->mailZones()->deleteCatchAll($domainName, $emailAddress);

    expect($response->status())->toBe(204);
});

// ============================================================================
// ConfigureAntiSpam Tests
// ============================================================================

it('builds PUT /mailzones/{domainName}/antispam', function () {
    $domainName = 'example.com';

    $mock = new MockClient([
        ConfigureAntiSpam::class => function (PendingRequest $p) use ($domainName) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe("/v2/mailzones/{$domainName}/antispam");
            expect($p->getMethod()->value)->toBe('PUT');

            return MockResponse::make('', 200);
        },
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $response = $sdk->mailZones()->configureAntiSpam($domainName);

    expect($response->status())->toBe(200);
});

// ============================================================================
// CreateAlias Tests
// ============================================================================

it('builds POST /mailzones/{domainName}/aliases with JSON body', function () {
    $domainName = 'example.com';

    $mock = new MockClient([
        CreateAlias::class => function (PendingRequest $p) use ($domainName) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe("/v2/mailzones/{$domainName}/aliases");
            expect($p->getMethod()->value)->toBe('POST');

            $body = $p->body()->all();
            expect($body)->toMatchArray([
                'email_address' => 'newalias@example.com',
                'destinations' => ['dest1@example.com', 'dest2@example.com'],
            ]);

            return MockResponse::make('', 201, [
                'Content-Type' => 'application/json',
            ]);
        },
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $request = new CreateAlias($domainName);
    $request->body()->merge([
        'email_address' => 'newalias@example.com',
        'destinations' => ['dest1@example.com', 'dest2@example.com'],
    ]);
    $response = $sdk->send($request);

    expect($response->status())->toBe(201);
});

// ============================================================================
// ConfigureAlias Tests
// ============================================================================

it('builds PUT /mailzones/{domainName}/aliases/{emailAddress}', function () {
    $domainName = 'example.com';
    $emailAddress = 'alias@example.com';

    $mock = new MockClient([
        ConfigureAlias::class => function (PendingRequest $p) use ($domainName, $emailAddress) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe("/v2/mailzones/{$domainName}/aliases/{$emailAddress}");
            expect($p->getMethod()->value)->toBe('PUT');

            return MockResponse::make('', 200);
        },
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $response = $sdk->mailZones()->configureAlias($domainName, $emailAddress);

    expect($response->status())->toBe(200);
});

// ============================================================================
// DeleteAlias Tests
// ============================================================================

it('builds DELETE /mailzones/{domainName}/aliases/{emailAddress}', function () {
    $domainName = 'example.com';
    $emailAddress = 'alias@example.com';

    $mock = new MockClient([
        DeleteAlias::class => function (PendingRequest $p) use ($domainName, $emailAddress) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe("/v2/mailzones/{$domainName}/aliases/{$emailAddress}");
            expect($p->getMethod()->value)->toBe('DELETE');

            return MockResponse::make('', 204);
        },
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $response = $sdk->mailZones()->deleteAlias($domainName, $emailAddress);

    expect($response->status())->toBe(204);
});

// ============================================================================
// CreateSmtpDomain Tests
// ============================================================================

it('builds POST /mailzones/{domainName}/smtpdomains with JSON body', function () {
    $domainName = 'example.com';

    $mock = new MockClient([
        CreateSmtpDomain::class => function (PendingRequest $p) use ($domainName) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe("/v2/mailzones/{$domainName}/smtpdomains");
            expect($p->getMethod()->value)->toBe('POST');

            $body = $p->body()->all();
            expect($body)->toMatchArray([
                'hostname' => 'smtp.example.com',
            ]);

            return MockResponse::make('', 201, [
                'Content-Type' => 'application/json',
            ]);
        },
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $request = new CreateSmtpDomain($domainName);
    $request->body()->merge([
        'hostname' => 'smtp.example.com',
    ]);
    $response = $sdk->send($request);

    expect($response->status())->toBe(201);
});

// ============================================================================
// ConfigureSmtpDomain Tests
// ============================================================================

it('builds PUT /mailzones/{domainName}/smtpdomains/{hostname}', function () {
    $domainName = 'example.com';
    $hostname = 'smtp.example.com';

    $mock = new MockClient([
        ConfigureSmtpDomain::class => function (PendingRequest $p) use ($domainName, $hostname) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe("/v2/mailzones/{$domainName}/smtpdomains/{$hostname}");
            expect($p->getMethod()->value)->toBe('PUT');

            return MockResponse::make('', 200);
        },
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $response = $sdk->mailZones()->configureSmtpDomain($domainName, $hostname);

    expect($response->status())->toBe(200);
});

// ============================================================================
// DeleteSmtpDomain Tests
// ============================================================================

it('builds DELETE /mailzones/{domainName}/smtpdomains/{hostname}', function () {
    $domainName = 'example.com';
    $hostname = 'smtp.example.com';

    $mock = new MockClient([
        DeleteSmtpDomain::class => function (PendingRequest $p) use ($domainName, $hostname) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe("/v2/mailzones/{$domainName}/smtpdomains/{$hostname}");
            expect($p->getMethod()->value)->toBe('DELETE');

            return MockResponse::make('', 204);
        },
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $response = $sdk->mailZones()->deleteSmtpDomain($domainName, $hostname);

    expect($response->status())->toBe(204);
});

// ============================================================================
// Edge Cases
// ============================================================================

it('handles mail zone with minimal data', function () {
    $mockData = [
        'name' => 'minimal.com',
        'enabled' => false,
        'available_accounts' => [],
        'aliases' => [],
        'anti_spam' => null,
        'catch_all' => null,
        'smtp_domains' => [],
    ];

    $mock = new MockClient([
        GetMailZone::class => MockResponse::make(json_encode($mockData), 200, [
            'Content-Type' => 'application/json',
        ]),
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $response = $sdk->mailZones()->getMailZone('minimal.com');

    /** @var MailZone $mailZone */
    $mailZone = $response->dto();

    expect($mailZone)->toBeInstanceOf(MailZone::class);
    expect($mailZone->name)->toBe('minimal.com');
    expect($mailZone->enabled)->toBe(false);
    expect($mailZone->antiSpam)->toBeNull();
    expect($mailZone->catchAll)->toBeNull();
});

it('handles domain names with subdomains', function () {
    $domainName = 'sub.example.com';

    $mock = new MockClient([
        GetMailZone::class => function (PendingRequest $p) use ($domainName) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe("/v2/mailzones/{$domainName}");

            return MockResponse::make('{}', 200, [
                'Content-Type' => 'application/json',
            ]);
        },
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $sdk->mailZones()->getMailZone($domainName);
});

it('handles email addresses with special characters in alias operations', function () {
    $domainName = 'example.com';
    $emailAddress = 'user+tag@example.com';

    $mock = new MockClient([
        DeleteAlias::class => function (PendingRequest $p) use ($emailAddress) {
            $uri = $p->getUri();
            // Email should appear in the path even if it contains special chars
            expect((string) $uri->getPath())->toContain($emailAddress);
            expect($p->getMethod()->value)->toBe('DELETE');

            return MockResponse::make('', 204);
        },
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $sdk->mailZones()->deleteAlias($domainName, $emailAddress);
});
