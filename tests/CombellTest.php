<?php

use Joehoel\Combell\Combell;
use Joehoel\Combell\Requests\Accounts\GetAccounts;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\PendingRequest;

it('exposes base URL and default auth', function () {
    $sdk = new Combell('abc', 'xyz');

    expect($sdk->resolveBaseUrl())->toBe('https://api.combell.nl/v2/');

    // Use a mock to send any request and read Authorization header
    $mock = new MockClient([
        GetAccounts::class => MockResponse::make('{}', 200),
    ]);

    // Attach a mock without using static helpers to keep this deterministic
    $sdk->withMockClient($mock);
    $sdk->accounts()->getAccounts();

    $pending = $mock->getLastPendingRequest();
    expect($pending)->not->toBeNull();

    $authHeader = $pending->headers()->get('Authorization');
    expect($authHeader)->toStartWith('hmac abc:');

    // Default headers present
    expect($pending->headers()->get('Accept'))->toBe('application/json');
    expect($pending->headers()->get('Content-Type'))->toBe('application/json');
});

it('Combell::fake accepts arrays and existing MockClient', function () {
    // Array of mocks keyed by request class
    $sdk = Combell::fake(
        [
            GetAccounts::class => MockResponse::make('{"items":[]}', 200, [
                'Content-Type' => 'application/json',
            ]),
        ],
        'k',
        's',
    );

    $sdk->accounts()->getAccounts();
    // Should be recorded
    $pending = $sdk->getMockClient()?->getLastPendingRequest();
    expect($pending)->not->toBeNull();

    // Existing MockClient instance
    $mock = new MockClient([
        GetAccounts::class => function (PendingRequest $p) {
            return MockResponse::make('{"ok":true}', 200, [
                'Content-Type' => 'application/json',
            ]);
        },
    ]);

    $sdk2 = Combell::fake($mock, 'k2', 's2');
    $sdk2->accounts()->getAccounts();
    expect($mock->getLastPendingRequest())->not->toBeNull();
});
