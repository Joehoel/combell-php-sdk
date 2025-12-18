<?php

use Joehoel\Combell\Combell;
use Joehoel\Combell\Dto\SslCertificate;
use Joehoel\Combell\Dto\SslCertificateDetail;
use Joehoel\Combell\Requests\SslCertificates\DownloadCertificate;
use Joehoel\Combell\Requests\SslCertificates\GetSslCertificate;
use Joehoel\Combell\Requests\SslCertificates\GetSslCertificates;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\PendingRequest;

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

it('builds GET /sslcertificates with pagination query params', function () {
    $mock = new MockClient([
        GetSslCertificates::class => function (PendingRequest $p) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe('/v2/sslcertificates');
            expect((string) $uri->getQuery())->toContain('skip=10');
            expect((string) $uri->getQuery())->toContain('take=25');

            return MockResponse::make('[]', 200, ['Content-Type' => 'application/json']);
        },
    ]);

    $sdk = Combell::fake($mock);
    $sdk->sslCertificates()->getSslCertificates(skip: 10, take: 25);
});

it('maps GetSslCertificate to SslCertificateDetail DTO', function () {
    $fingerprint = 'abc123';

    $mock = new MockClient([
        GetSslCertificate::class => MockResponse::make(json_encode([
            'sha1_fingerprint' => $fingerprint,
            'common_name' => 'secure.example.com',
            'expires_after' => '2025-05-01',
            'validation_level' => 'organization',
            'type' => 'standard',
            'subject_alt_names' => ['www.example.com', 'example.com'],
        ]), 200, ['Content-Type' => 'application/json']),
    ]);

    $sdk = Combell::fake($mock);
    $response = $sdk->sslCertificates()->getSslCertificate($fingerprint);

    /** @var SslCertificateDetail $detail */
    $detail = $response->dto();

    expect($detail)->toBeInstanceOf(SslCertificateDetail::class);
    expect($detail->sha1Fingerprint)->toBe($fingerprint);
    expect($detail->subjectAltNames)->toMatchArray(['www.example.com', 'example.com']);
});

it('builds GET /sslcertificates/{fingerprint} for detail', function () {
    $fingerprint = 'xyz789';

    $mock = new MockClient([
        GetSslCertificate::class => function (PendingRequest $p) use ($fingerprint) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe("/v2/sslcertificates/{$fingerprint}");
            expect($p->getMethod()->value)->toBe('GET');

            return MockResponse::make('{}', 200, ['Content-Type' => 'application/json']);
        },
    ]);

    $sdk = Combell::fake($mock);
    $sdk->sslCertificates()->getSslCertificate($fingerprint);
});

it('builds GET /sslcertificates/{fingerprint}/download with query params', function () {
    $fingerprint = 'abc123';
    $fileFormat = 'PFX';
    $password = 'SecretP@ss';

    $mock = new MockClient([
        DownloadCertificate::class => function (PendingRequest $p) use ($fingerprint, $fileFormat, $password) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe("/v2/sslcertificates/{$fingerprint}/download");
            $query = (string) $uri->getQuery();
            expect($query)->toContain('file_format='.$fileFormat);
            expect($query)->toContain('password='.urlencode($password));
            expect($p->getMethod()->value)->toBe('GET');

            return MockResponse::make('BINARYDATA', 200, ['Content-Type' => 'application/octet-stream']);
        },
    ]);

    $sdk = Combell::fake($mock);
    $response = $sdk->sslCertificates()->downloadCertificate($fingerprint, $fileFormat, $password);

    expect($response->body())->toBe('BINARYDATA');
});
