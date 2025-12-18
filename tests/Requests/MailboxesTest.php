<?php

use Joehoel\Combell\Combell;
use Joehoel\Combell\Dto\Mailbox;
use Joehoel\Combell\Dto\MailboxDetail;
use Joehoel\Combell\Requests\Mailboxes\ChangeMailboxPassword;
use Joehoel\Combell\Requests\Mailboxes\ConfigureMailboxAutoForward;
use Joehoel\Combell\Requests\Mailboxes\ConfigureMailboxAutoReply;
use Joehoel\Combell\Requests\Mailboxes\CreateMailbox;
use Joehoel\Combell\Requests\Mailboxes\DeleteMailbox;
use Joehoel\Combell\Requests\Mailboxes\GetMailbox;
use Joehoel\Combell\Requests\Mailboxes\GetMailboxes;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\PendingRequest;

// ============================================================================
// GetMailboxes Tests
// ============================================================================

it('builds GET /mailboxes with no query by default', function () {
    $mock = new MockClient([
        GetMailboxes::class => function (PendingRequest $p) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe('/v2/mailboxes');
            expect((string) $uri->getQuery())->toBe('');
            expect($p->getMethod()->value)->toBe('GET');

            return MockResponse::make('[]', 200, [
                'Content-Type' => 'application/json',
            ]);
        },
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $sdk->mailboxes()->getMailboxes();
});

it('builds GET /mailboxes with domain_name query param', function () {
    $domainName = 'example.com';

    $mock = new MockClient([
        GetMailboxes::class => function (PendingRequest $p) use ($domainName) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe('/v2/mailboxes');
            expect((string) $uri->getQuery())->toContain('domain_name='.urlencode($domainName));
            expect($p->getMethod()->value)->toBe('GET');

            return MockResponse::make('[]', 200, [
                'Content-Type' => 'application/json',
            ]);
        },
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $sdk->mailboxes()->getMailboxes($domainName);
});

it('maps GetMailboxes to Mailbox DTO list', function () {
    $mockData = [
        [
            'name' => 'info@example.com',
            'max_size' => 5000,
            'actual_size' => 1234,
        ],
        [
            'name' => 'support@example.com',
            'max_size' => 10000,
            'actual_size' => 567,
        ],
    ];

    $mock = new MockClient([
        GetMailboxes::class => MockResponse::make(json_encode($mockData), 200, [
            'Content-Type' => 'application/json',
        ]),
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $response = $sdk->mailboxes()->getMailboxes();

    /** @var Mailbox[] $mailboxes */
    $mailboxes = $response->dto();

    expect($mailboxes)->toBeArray();
    expect($mailboxes)->toHaveCount(2);
    expect($mailboxes[0])->toBeInstanceOf(Mailbox::class);
    expect($mailboxes[0]->name)->toBe('info@example.com');
    expect($mailboxes[0]->maxSize)->toBe(5000);
    expect($mailboxes[0]->actualSize)->toBe(1234);
    expect($mailboxes[1]->name)->toBe('support@example.com');
});

// ============================================================================
// GetMailbox Tests
// ============================================================================

it('builds GET /mailboxes/{mailboxName}', function () {
    $mailboxName = 'info@example.com';

    $mock = new MockClient([
        GetMailbox::class => function (PendingRequest $p) use ($mailboxName) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe('/v2/mailboxes/'.$mailboxName);
            expect($p->getMethod()->value)->toBe('GET');

            return MockResponse::make('{}', 200, [
                'Content-Type' => 'application/json',
            ]);
        },
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $sdk->mailboxes()->getMailbox($mailboxName);
});

it('maps GetMailbox to single MailboxDetail DTO', function () {
    $mockData = [
        'name' => 'info@example.com',
        'login' => 'info@example.com',
        'max_size' => 5000,
        'actual_size' => 1234,
        'auto_reply' => [
            'enabled' => true,
            'subject' => 'Out of Office',
            'message' => 'I am currently out of the office.',
        ],
        'auto_forward' => [
            'enabled' => false,
            'email_addresses' => ['forward@example.com'],
            'copy_to_myself' => true,
        ],
    ];

    $mock = new MockClient([
        GetMailbox::class => MockResponse::make(json_encode($mockData), 200, [
            'Content-Type' => 'application/json',
        ]),
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $response = $sdk->mailboxes()->getMailbox('info@example.com');

    /** @var MailboxDetail $mailbox */
    $mailbox = $response->dto();

    expect($mailbox)->toBeInstanceOf(MailboxDetail::class);
    expect($mailbox->name)->toBe('info@example.com');
    expect($mailbox->login)->toBe('info@example.com');
    expect($mailbox->maxSize)->toBe(5000);
    expect($mailbox->actualSize)->toBe(1234);
    expect($mailbox->autoReply)->not->toBeNull();
    expect($mailbox->autoForward)->not->toBeNull();
});

// ============================================================================
// CreateMailbox Tests
// ============================================================================

it('builds POST /mailboxes with JSON body', function () {
    $mock = new MockClient([
        CreateMailbox::class => function (PendingRequest $p) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe('/v2/mailboxes');
            expect($p->getMethod()->value)->toBe('POST');

            $body = $p->body()->all();
            expect($body)->toMatchArray([
                'email_address' => 'new@example.com',
                'account_id' => 12345,
                'password' => 'SecureP@ss123',
            ]);

            return MockResponse::make('', 201, [
                'Content-Type' => 'application/json',
            ]);
        },
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $request = new CreateMailbox;
    $request->body()->merge([
        'email_address' => 'new@example.com',
        'account_id' => 12345,
        'password' => 'SecureP@ss123',
    ]);
    $response = $sdk->send($request);

    expect($response->status())->toBe(201);
});

// ============================================================================
// DeleteMailbox Tests
// ============================================================================

it('builds DELETE /mailboxes/{mailboxName}', function () {
    $mailboxName = 'delete@example.com';

    $mock = new MockClient([
        DeleteMailbox::class => function (PendingRequest $p) use ($mailboxName) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe('/v2/mailboxes/'.$mailboxName);
            expect($p->getMethod()->value)->toBe('DELETE');

            return MockResponse::make('', 204);
        },
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $response = $sdk->mailboxes()->deleteMailbox($mailboxName);

    expect($response->status())->toBe(204);
});

// ============================================================================
// ChangeMailboxPassword Tests
// ============================================================================

it('builds PUT /mailboxes/{mailboxName}/password', function () {
    $mailboxName = 'info@example.com';

    $mock = new MockClient([
        ChangeMailboxPassword::class => function (PendingRequest $p) use ($mailboxName) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe('/v2/mailboxes/'.$mailboxName.'/password');
            expect($p->getMethod()->value)->toBe('PUT');

            return MockResponse::make('', 200);
        },
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $response = $sdk->mailboxes()->changeMailboxPassword($mailboxName);

    expect($response->status())->toBe(200);
});

// ============================================================================
// ConfigureMailboxAutoReply Tests
// ============================================================================

it('builds PUT /mailboxes/{mailboxName}/autoreply', function () {
    $mailboxName = 'info@example.com';

    $mock = new MockClient([
        ConfigureMailboxAutoReply::class => function (PendingRequest $p) use ($mailboxName) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe('/v2/mailboxes/'.$mailboxName.'/autoreply');
            expect($p->getMethod()->value)->toBe('PUT');

            return MockResponse::make('', 200);
        },
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $response = $sdk->mailboxes()->configureMailboxAutoReply($mailboxName);

    expect($response->status())->toBe(200);
});

// ============================================================================
// ConfigureMailboxAutoForward Tests
// ============================================================================

it('builds PUT /mailboxes/{mailboxName}/autoforward', function () {
    $mailboxName = 'info@example.com';

    $mock = new MockClient([
        ConfigureMailboxAutoForward::class => function (PendingRequest $p) use ($mailboxName) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe('/v2/mailboxes/'.$mailboxName.'/autoforward');
            expect($p->getMethod()->value)->toBe('PUT');

            return MockResponse::make('', 200);
        },
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $response = $sdk->mailboxes()->configureMailboxAutoForward($mailboxName);

    expect($response->status())->toBe(200);
});

// ============================================================================
// Edge Cases
// ============================================================================

it('handles empty mailbox list', function () {
    $mock = new MockClient([
        GetMailboxes::class => MockResponse::make('[]', 200, [
            'Content-Type' => 'application/json',
        ]),
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $response = $sdk->mailboxes()->getMailboxes();

    $mailboxes = $response->dto();
    expect($mailboxes)->toBeArray();
    expect($mailboxes)->toHaveCount(0);
});

it('handles mailbox names with special characters', function () {
    $mailboxName = 'user+tag@example.com';

    $mock = new MockClient([
        GetMailbox::class => function (PendingRequest $p) use ($mailboxName) {
            $uri = $p->getUri();
            // The mailbox name should appear verbatim in the path
            expect((string) $uri->getPath())->toContain($mailboxName);

            return MockResponse::make('{}', 200, [
                'Content-Type' => 'application/json',
            ]);
        },
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $sdk->mailboxes()->getMailbox($mailboxName);
});

it('maps mailbox with null auto_reply and auto_forward', function () {
    $mockData = [
        'name' => 'basic@example.com',
        'login' => 'basic@example.com',
        'max_size' => 1000,
        'actual_size' => 100,
        'auto_reply' => null,
        'auto_forward' => null,
    ];

    $mock = new MockClient([
        GetMailbox::class => MockResponse::make(json_encode($mockData), 200, [
            'Content-Type' => 'application/json',
        ]),
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $response = $sdk->mailboxes()->getMailbox('basic@example.com');

    /** @var MailboxDetail $mailbox */
    $mailbox = $response->dto();

    expect($mailbox)->toBeInstanceOf(MailboxDetail::class);
    expect($mailbox->autoReply)->toBeNull();
    expect($mailbox->autoForward)->toBeNull();
});
