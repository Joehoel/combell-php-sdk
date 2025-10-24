<?php

use Joehoel\Combell\Combell;
use Joehoel\Combell\Dto\SslCertificate;
use Joehoel\Combell\Requests\SslCertificates\GetSslCertificates;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

it('maps GetSslCertificates to SslCertificate DTO list', function () {
    $mockClient = new MockClient([
        GetSslCertificates::class => MockResponse::make(
            body: json_encode([
                ['sha1_fingerprint' => 'abc123', 'common_name' => 'example.com', 'type' => 'standard'],
                ['sha1_fingerprint' => 'def456', 'common_name' => 'test.be', 'type' => 'wildcard'],
            ]),
            status: 200,
            headers: ['Content-Type' => 'application/json'],
        ),
    ]);

    $sdk = Combell::fake($mockClient);
    $response = $sdk->sslCertificates()->getSslCertificates();

    /** @var SslCertificate[] $certificates */
    $certificates = $response->dto();

    expect($certificates)->toBeArray();
    expect($certificates)->toHaveCount(2);
    expect($certificates[0])->toBeInstanceOf(SslCertificate::class);
    expect($certificates[0]->commonName)->toBe('example.com');
    expect($certificates[0]->type)->toBe('standard');
});
