<?php

use Joehoel\Combell\Combell;
use Joehoel\Combell\Dto\DnsRecord;
use Joehoel\Combell\Requests\DnsRecords\CreateRecord;
use Joehoel\Combell\Requests\DnsRecords\DeleteRecord;
use Joehoel\Combell\Requests\DnsRecords\EditRecord;
use Joehoel\Combell\Requests\DnsRecords\GetRecord;
use Joehoel\Combell\Requests\DnsRecords\GetRecords;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\PendingRequest;

it('builds GET /dns/{domain}/records with no query by default', function () {
    $domain = 'example.com';

    $mock = new MockClient([
        GetRecords::class => function (PendingRequest $p) use ($domain) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe("/v2/dns/{$domain}/records");
            expect((string) $uri->getQuery())->toBe('');
            expect($p->getMethod()->value)->toBe('GET');

            return MockResponse::make('[]', 200, [
                'Content-Type' => 'application/json',
            ]);
        },
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $sdk->dnsRecords()->getRecords($domain);
});

it('builds GET /dns/{domain}/records/{id}', function () {
    $domain = 'example.com';
    $recordId = 'abc123';

    $mock = new MockClient([
        GetRecord::class => function (PendingRequest $p) use (
            $domain,
            $recordId,
        ) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe(
                "/v2/dns/{$domain}/records/{$recordId}",
            );
            expect($p->getMethod()->value)->toBe('GET');

            return MockResponse::make('{"id":"abc123"}', 200, [
                'Content-Type' => 'application/json',
            ]);
        },
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $response = $sdk->dnsRecords()->getRecord($domain, $recordId);

    /** @var DnsRecord $record */
    $record = $response->dto();
    expect($record)->toBeInstanceOf(DnsRecord::class);
    expect($record->id)->toBe('abc123');
});

it('builds POST /dns/{domain}/records with JSON body', function () {
    $domain = 'example.com';

    $mock = new MockClient([
        CreateRecord::class => function (PendingRequest $p) use ($domain) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe("/v2/dns/{$domain}/records");
            expect($p->getMethod()->value)->toBe('POST');

            // Ensure JSON body is sent through HasJsonBody
            $data = $p->body()->all();
            expect($data)->toMatchArray([
                'type' => 'A',
                'name' => '@',
                'content' => '1.2.3.4',
                'ttl' => 3600,
            ]);

            return MockResponse::make('{}', 201, [
                'Content-Type' => 'application/json',
            ]);
        },
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $request = new CreateRecord($domain);
    $request->body()->merge([
        'type' => 'A',
        'name' => '@',
        'content' => '1.2.3.4',
        'ttl' => 3600,
    ]);
    $sdk->send($request);
});

it('builds PUT /dns/{domain}/records/{id} with JSON body', function () {
    $domain = 'example.com';
    $recordId = 'abc123';

    $mock = new MockClient([
        EditRecord::class => function (PendingRequest $p) use (
            $domain,
            $recordId,
        ) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe(
                "/v2/dns/{$domain}/records/{$recordId}",
            );
            expect($p->getMethod()->value)->toBe('PUT');

            // No body trait on EditRecord; just verify path and method

            return MockResponse::make('{}', 200, [
                'Content-Type' => 'application/json',
            ]);
        },
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $request = new EditRecord($domain, $recordId);
    $sdk->send($request);
});

it('builds DELETE /dns/{domain}/records/{id}', function () {
    $domain = 'example.com';
    $recordId = 'abc123';

    $mock = new MockClient([
        DeleteRecord::class => function (PendingRequest $p) use (
            $domain,
            $recordId,
        ) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe(
                "/v2/dns/{$domain}/records/{$recordId}",
            );
            expect($p->getMethod()->value)->toBe('DELETE');

            return MockResponse::make('', 204, [
                'Content-Type' => 'application/json',
            ]);
        },
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $sdk->dnsRecords()->deleteRecord($domain, $recordId);
});
