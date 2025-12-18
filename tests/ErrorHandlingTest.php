<?php

use Joehoel\Combell\Combell;
use Joehoel\Combell\Requests\Domains\GetDomains;
use Joehoel\Combell\Requests\SslCertificates\DownloadCertificate;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

it('throws a RequestException for non-success responses', function () {
    $mock = new MockClient([
        GetDomains::class => MockResponse::make('{"error":"forbidden"}', 403, [
            'Content-Type' => 'application/json',
        ]),
    ]);

    $sdk = Combell::fake($mock, 'key', 'secret');

    expect(fn () => $sdk->domains()->getDomains())
        ->toThrow(RequestException::class, 'forbidden');
});

it('still returns raw body for binary downloads on success', function () {
    $fingerprint = 'abc123';

    $mock = new MockClient([
        DownloadCertificate::class => MockResponse::make('FAKE-BINARY', 200, [
            'Content-Type' => 'application/octet-stream',
        ]),
    ]);

    $sdk = Combell::fake($mock, 'key', 'secret');

    $response = $sdk->sslCertificates()->downloadCertificate($fingerprint, 'PFX', 'secret');

    expect($response->body())->toBe('FAKE-BINARY');
});
