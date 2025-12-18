<?php

use Joehoel\Combell\Combell;
use Joehoel\Combell\Dto\SshKey;
use Joehoel\Combell\Requests\Ssh\GetAllSshKeys;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\PendingRequest;

it('builds GET /ssh with no query by default', function () {
    $mock = new MockClient([
        GetAllSshKeys::class => function (PendingRequest $p) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe('/v2/ssh');
            expect((string) $uri->getQuery())->toBe('');
            expect($p->getMethod()->value)->toBe('GET');

            return MockResponse::make('[]', 200, [
                'Content-Type' => 'application/json',
            ]);
        },
    ]);

    $sdk = Combell::fake($mock, 'key', 'secret');
    $sdk->ssh()->getAllSshKeys();
});

it('builds GET /ssh with skip and take query params', function () {
    $mock = new MockClient([
        GetAllSshKeys::class => function (PendingRequest $p) {
            $uri = $p->getUri();
            expect((string) $uri->getQuery())->toContain('skip=10');
            expect((string) $uri->getQuery())->toContain('take=25');

            return MockResponse::make('[]', 200, [
                'Content-Type' => 'application/json',
            ]);
        },
    ]);

    $sdk = Combell::fake($mock, 'key', 'secret');
    $sdk->ssh()->getAllSshKeys(skip: 10, take: 25);
});

it('maps GetAllSshKeys to SshKey DTO list', function () {
    $mockData = [
        ['fingerprint' => 'fp1', 'public_key' => 'ssh-rsa AAA...'],
        ['fingerprint' => 'fp2', 'public_key' => 'ssh-ed25519 BBB...'],
    ];

    $mock = new MockClient([
        GetAllSshKeys::class => MockResponse::make(json_encode($mockData), 200, [
            'Content-Type' => 'application/json',
        ]),
    ]);

    $sdk = Combell::fake($mock, 'key', 'secret');
    $response = $sdk->ssh()->getAllSshKeys();

    /** @var SshKey[] $keys */
    $keys = $response->dto();

    expect($keys)->toBeArray();
    expect($keys)->toHaveCount(2);
    expect($keys[0])->toBeInstanceOf(SshKey::class);
    expect($keys[0]->fingerprint)->toBe('fp1');
    expect($keys[1]->publicKey)->toContain('BBB');
});
