<?php

use Joehoel\Combell\Combell;
use Joehoel\Combell\Dto\AccountDetail;
use Joehoel\Combell\Requests\Accounts\GetAccount;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

it('sends GetAccount request and returns data', function () {
    $accountId = 123;

    // Prepare a local MockClient and attach via instance fake()
    $mockClient = new MockClient([
        GetAccount::class => MockResponse::make(
            body: json_encode([
                'id' => $accountId,
                'identifier' => 'example.com',
            ]),
            status: 200,
            headers: ['Content-Type' => 'application/json'],
        ),
    ]);
    $sdk = Combell::fake($mockClient);

    $response = $sdk->accounts()->getAccount($accountId);

    expect($response->status())->toBe(200);
    expect($response->json('id'))->toBe($accountId);

    // DTO mapping
    /** @var AccountDetail $dto */
    $dto = $response->dto();
    expect($dto)->toBeInstanceOf(AccountDetail::class);
    expect($dto->id)->toBe($accountId);
    expect($dto->identifier)->toBe('example.com');

    // Ensure the specific request was sent
    $mockClient->assertSent(GetAccount::class);
});
