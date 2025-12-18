<?php

use Joehoel\Combell\Combell;
use Joehoel\Combell\Dto\SslCertificateRequest;
use Joehoel\Combell\Dto\SslCertificateRequestDetail;
use Joehoel\Combell\Requests\SslCertificateRequests\AddSslCertificateRequest;
use Joehoel\Combell\Requests\SslCertificateRequests\GetSslCertificateRequest;
use Joehoel\Combell\Requests\SslCertificateRequests\GetSslCertificateRequests;
use Joehoel\Combell\Requests\SslCertificateRequests\VerifySslCertificateRequestDomainValidations;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\PendingRequest;

// ============================================================================
// GetSslCertificateRequests Tests
// ============================================================================

it('builds GET /sslcertificaterequests with no query by default', function () {
    $mock = new MockClient([
        GetSslCertificateRequests::class => function (PendingRequest $p) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe('/v2/sslcertificaterequests');
            expect((string) $uri->getQuery())->toBe('');
            expect($p->getMethod()->value)->toBe('GET');

            return MockResponse::make('[]', 200, [
                'Content-Type' => 'application/json',
            ]);
        },
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $sdk->sslCertificateRequests()->getSslCertificateRequests();
});

it('builds GET /sslcertificaterequests with skip and take query params', function () {
    $mock = new MockClient([
        GetSslCertificateRequests::class => function (PendingRequest $p) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe('/v2/sslcertificaterequests');
            expect((string) $uri->getQuery())->toContain('skip=2');
            expect((string) $uri->getQuery())->toContain('take=5');

            return MockResponse::make('[]', 200, [
                'Content-Type' => 'application/json',
            ]);
        },
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $sdk->sslCertificateRequests()->getSslCertificateRequests(skip: 2, take: 5);
});

it('maps GetSslCertificateRequests to SslCertificateRequest DTO list', function () {
    $mockData = [
        [
            'id' => 1,
            'certificate_type' => 'standard',
            'validation_level' => 'domain',
            'vendor' => 'Sectigo',
            'common_name' => 'example.com',
            'order_code' => 'ORD-1',
        ],
        [
            'id' => 2,
            'certificate_type' => 'wildcard',
            'validation_level' => 'organization',
            'vendor' => 'Digicert',
            'common_name' => '*.example.net',
            'order_code' => 'ORD-2',
        ],
    ];

    $mock = new MockClient([
        GetSslCertificateRequests::class => MockResponse::make(json_encode($mockData), 200, [
            'Content-Type' => 'application/json',
        ]),
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $response = $sdk->sslCertificateRequests()->getSslCertificateRequests();

    /** @var SslCertificateRequest[] $requests */
    $requests = $response->dto();

    expect($requests)->toBeArray();
    expect($requests)->toHaveCount(2);
    expect($requests[0])->toBeInstanceOf(SslCertificateRequest::class);
    expect($requests[0]->id)->toBe(1);
    expect($requests[0]->certificateType)->toBe('standard');
    expect($requests[1]->validationLevel)->toBe('organization');
    expect($requests[1]->commonName)->toBe('*.example.net');
});

// ============================================================================
// GetSslCertificateRequest Tests
// ============================================================================

it('builds GET /sslcertificaterequests/{id}', function () {
    $id = 123;

    $mock = new MockClient([
        GetSslCertificateRequest::class => function (PendingRequest $p) use ($id) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe("/v2/sslcertificaterequests/{$id}");
            expect($p->getMethod()->value)->toBe('GET');

            return MockResponse::make('{}', 200, [
                'Content-Type' => 'application/json',
            ]);
        },
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $sdk->sslCertificateRequests()->getSslCertificateRequest($id);
});

it('maps GetSslCertificateRequest to SslCertificateRequestDetail DTO', function () {
    $mockData = [
        'id' => 100,
        'certificate_type' => 'ev',
        'validation_level' => 'extended',
        'vendor' => 'Sectigo',
        'common_name' => 'secure.example.com',
        'order_code' => 'ORD-100',
        'subject_alt_names' => ['www.example.com', 'example.com'],
        'validations' => [
            ['domain' => 'example.com', 'status' => 'pending'],
        ],
        'provider_portal_url' => 'https://portal.example.com/order/ORD-100',
    ];

    $mock = new MockClient([
        GetSslCertificateRequest::class => MockResponse::make(json_encode($mockData), 200, [
            'Content-Type' => 'application/json',
        ]),
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $response = $sdk->sslCertificateRequests()->getSslCertificateRequest(100);

    /** @var SslCertificateRequestDetail $detail */
    $detail = $response->dto();

    expect($detail)->toBeInstanceOf(SslCertificateRequestDetail::class);
    expect($detail->id)->toBe(100);
    expect($detail->certificateType)->toBe('ev');
    expect($detail->subjectAltNames)->toMatchArray(['www.example.com', 'example.com']);
    expect($detail->validations)->toHaveCount(1);
    expect($detail->providerPortalUrl)->toBe('https://portal.example.com/order/ORD-100');
});

// ============================================================================
// AddSslCertificateRequest Tests
// ============================================================================

it('builds POST /sslcertificaterequests with JSON body', function () {
    $mock = new MockClient([
        AddSslCertificateRequest::class => function (PendingRequest $p) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe('/v2/sslcertificaterequests');
            expect($p->getMethod()->value)->toBe('POST');

            $body = $p->body()->all();
            expect($body)->toMatchArray([
                'certificate_type' => 'standard',
                'common_name' => 'example.com',
                'account_id' => 12345,
            ]);

            return MockResponse::make('', 201, [
                'Content-Type' => 'application/json',
            ]);
        },
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $request = new AddSslCertificateRequest;
    $request->body()->merge([
        'certificate_type' => 'standard',
        'common_name' => 'example.com',
        'account_id' => 12345,
    ]);
    $response = $sdk->send($request);

    expect($response->status())->toBe(201);
});

// ============================================================================
// VerifySslCertificateRequestDomainValidations Tests
// ============================================================================

it('builds PUT /sslcertificaterequests/{id} for validation verification', function () {
    $id = 555;

    $mock = new MockClient([
        VerifySslCertificateRequestDomainValidations::class => function (PendingRequest $p) use ($id) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe("/v2/sslcertificaterequests/{$id}");
            expect($p->getMethod()->value)->toBe('PUT');

            return MockResponse::make('', 204);
        },
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $response = $sdk->sslCertificateRequests()->verifySslCertificateRequestDomainValidations($id);

    expect($response->status())->toBe(204);
});

// ============================================================================
// Edge Cases
// ============================================================================

it('handles empty certificate request list', function () {
    $mock = new MockClient([
        GetSslCertificateRequests::class => MockResponse::make('[]', 200, [
            'Content-Type' => 'application/json',
        ]),
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $response = $sdk->sslCertificateRequests()->getSslCertificateRequests();

    $requests = $response->dto();
    expect($requests)->toBeArray();
    expect($requests)->toHaveCount(0);
});
