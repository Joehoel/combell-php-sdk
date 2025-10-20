<?php

use Joehoel\Combell\Combell;
use Joehoel\Combell\Dto\Account;
use Joehoel\Combell\Requests\Accounts\GetAccounts;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

it('maps GetAccounts to Account DTO list', function () {
    $mockClient = new MockClient([
        GetAccounts::class => MockResponse::make(
            body: json_encode([
                ['id' => 1, 'identifier' => 'one.test'],
                ['id' => 2, 'identifier' => 'two.test'],
            ]),
            status: 200,
            headers: ['Content-Type' => 'application/json'],
        ),
    ]);

    $sdk = Combell::fake($mockClient);
    $response = $sdk->accounts()->getAccounts();

    /** @var Account[] $accounts */
    $accounts = $response->dto();

    expect($accounts)->toBeArray();
    expect($accounts)->toHaveCount(2);
    expect($accounts[0])->toBeInstanceOf(Account::class);
    expect($accounts[0]->identifier)->toBe('one.test');
});
