<?php

use Joehoel\Combell\Combell;
use Joehoel\Combell\Requests\Accounts\GetAccounts;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\PendingRequest;

it('filters nulls from GetAccounts query params', function () {
    $mock = new MockClient([
        GetAccounts::class => function (PendingRequest $p) {
            $uri = $p->getUri();
            $query = (string) $uri->getQuery();

            // Should only contain the provided values
            expect($query)->toContain('skip=10');
            expect($query)->toContain('asset_type=linux');
            expect($query)->not->toContain('take=');
            expect($query)->not->toContain('identifier=');

            return MockResponse::make('{"items":[]}', 200, ['Content-Type' => 'application/json']);
        },
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $sdk->accounts()->getAccounts(skip: 10, take: null, assetType: 'linux', identifier: null);
});
