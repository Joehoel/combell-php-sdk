<?php

use Joehoel\Combell\Combell;
use Joehoel\Combell\Requests\Accounts\CreateAccount;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\PendingRequest;

it('builds POST /accounts with JSON body', function () {
    $mock = new MockClient([
        CreateAccount::class => function (PendingRequest $p) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe('/v2/accounts');
            expect($p->getMethod()->value)->toBe('POST');

            $body = $p->body()->all();
            expect($body)->toMatchArray([
                'identifier' => 'new-account.example',
                'account_id' => 9876,
                'servicepack_id' => 123,
            ]);

            return MockResponse::make('', 202, [
                'Content-Type' => 'application/json',
            ]);
        },
    ]);

    $sdk = Combell::fake($mock, 'key', 'secret');
    $request = new CreateAccount;
    $request->body()->merge([
        'identifier' => 'new-account.example',
        'account_id' => 9876,
        'servicepack_id' => 123,
    ]);

    $response = $sdk->send($request);

    expect($response->status())->toBe(202);
});
