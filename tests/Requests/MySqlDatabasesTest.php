<?php

use Joehoel\Combell\Combell;
use Joehoel\Combell\Dto\MySqlDatabase;
use Joehoel\Combell\Dto\MySqlUser;
use Joehoel\Combell\Requests\MySqlDatabases\ChangeDatabaseUserPassword;
use Joehoel\Combell\Requests\MySqlDatabases\ChangeDatabaseUserStatus;
use Joehoel\Combell\Requests\MySqlDatabases\CreateMySqlDatabase;
use Joehoel\Combell\Requests\MySqlDatabases\CreateMySqlUser;
use Joehoel\Combell\Requests\MySqlDatabases\DeleteDatabase;
use Joehoel\Combell\Requests\MySqlDatabases\DeleteDatabaseUser;
use Joehoel\Combell\Requests\MySqlDatabases\GetDatabaseUsers;
use Joehoel\Combell\Requests\MySqlDatabases\GetMySqlDatabase;
use Joehoel\Combell\Requests\MySqlDatabases\GetMySqlDatabases;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\PendingRequest;

// ============================================================================
// GetMySqlDatabases Tests
// ============================================================================

it('builds GET /mysqldatabases with no query by default', function () {
    $mock = new MockClient([
        GetMySqlDatabases::class => function (PendingRequest $p) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe('/v2/mysqldatabases');
            expect((string) $uri->getQuery())->toBe('');
            expect($p->getMethod()->value)->toBe('GET');

            return MockResponse::make('[]', 200, [
                'Content-Type' => 'application/json',
            ]);
        },
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $sdk->mySqlDatabases()->getMySqlDatabases();
});

it('builds GET /mysqldatabases with skip and take query params', function () {
    $mock = new MockClient([
        GetMySqlDatabases::class => function (PendingRequest $p) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe('/v2/mysqldatabases');
            expect((string) $uri->getQuery())->toContain('skip=10');
            expect((string) $uri->getQuery())->toContain('take=20');

            return MockResponse::make('[]', 200, [
                'Content-Type' => 'application/json',
            ]);
        },
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $sdk->mySqlDatabases()->getMySqlDatabases(skip: 10, take: 20);
});

it('maps GetMySqlDatabases to MySqlDatabase DTO list', function () {
    $mockData = [
        [
            'name' => 'db_one',
            'hostname' => 'mysql1.example.com',
            'user_count' => 2,
            'max_size' => 1073741824,
            'actual_size' => 524288000,
            'account_id' => 12345,
        ],
        [
            'name' => 'db_two',
            'hostname' => 'mysql2.example.com',
            'user_count' => 1,
            'max_size' => 2147483648,
            'actual_size' => 1073741824,
            'account_id' => 67890,
        ],
    ];

    $mock = new MockClient([
        GetMySqlDatabases::class => MockResponse::make(json_encode($mockData), 200, [
            'Content-Type' => 'application/json',
        ]),
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $response = $sdk->mySqlDatabases()->getMySqlDatabases();

    /** @var MySqlDatabase[] $databases */
    $databases = $response->dto();

    expect($databases)->toBeArray();
    expect($databases)->toHaveCount(2);
    expect($databases[0])->toBeInstanceOf(MySqlDatabase::class);
    expect($databases[0]->name)->toBe('db_one');
    expect($databases[0]->hostname)->toBe('mysql1.example.com');
    expect($databases[0]->userCount)->toBe(2);
    expect($databases[1]->name)->toBe('db_two');
    expect($databases[1]->accountId)->toBe(67890);
});

// ============================================================================
// GetMySqlDatabase Tests
// ============================================================================

it('builds GET /mysqldatabases/{databaseName}', function () {
    $databaseName = 'test_database';

    $mock = new MockClient([
        GetMySqlDatabase::class => function (PendingRequest $p) use ($databaseName) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe("/v2/mysqldatabases/{$databaseName}");
            expect($p->getMethod()->value)->toBe('GET');

            return MockResponse::make('{}', 200, [
                'Content-Type' => 'application/json',
            ]);
        },
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $sdk->mySqlDatabases()->getMySqlDatabase($databaseName);
});

it('maps GetMySqlDatabase to single MySqlDatabase DTO', function () {
    $mockData = [
        'name' => 'my_database',
        'hostname' => 'mysql.example.com',
        'user_count' => 3,
        'max_size' => 1073741824,
        'actual_size' => 500000000,
        'account_id' => 11111,
    ];

    $mock = new MockClient([
        GetMySqlDatabase::class => MockResponse::make(json_encode($mockData), 200, [
            'Content-Type' => 'application/json',
        ]),
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $response = $sdk->mySqlDatabases()->getMySqlDatabase('my_database');

    /** @var MySqlDatabase $database */
    $database = $response->dto();

    expect($database)->toBeInstanceOf(MySqlDatabase::class);
    expect($database->name)->toBe('my_database');
    expect($database->hostname)->toBe('mysql.example.com');
    expect($database->userCount)->toBe(3);
    expect($database->maxSize)->toBe(1073741824);
    expect($database->actualSize)->toBe(500000000);
    expect($database->accountId)->toBe(11111);
});

// ============================================================================
// CreateMySqlDatabase Tests
// ============================================================================

it('builds POST /mysqldatabases with JSON body', function () {
    $mock = new MockClient([
        CreateMySqlDatabase::class => function (PendingRequest $p) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe('/v2/mysqldatabases');
            expect($p->getMethod()->value)->toBe('POST');

            $body = $p->body()->all();
            expect($body)->toMatchArray([
                'database_name' => 'new_database',
                'account_id' => 12345,
                'password' => 'SecureP@ss123',
            ]);

            return MockResponse::make('', 201, [
                'Content-Type' => 'application/json',
            ]);
        },
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $request = new CreateMySqlDatabase;
    $request->body()->merge([
        'database_name' => 'new_database',
        'account_id' => 12345,
        'password' => 'SecureP@ss123',
    ]);
    $response = $sdk->send($request);

    expect($response->status())->toBe(201);
});

// ============================================================================
// DeleteDatabase Tests
// ============================================================================

it('builds DELETE /mysqldatabases/{databaseName}', function () {
    $databaseName = 'database_to_delete';

    $mock = new MockClient([
        DeleteDatabase::class => function (PendingRequest $p) use ($databaseName) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe("/v2/mysqldatabases/{$databaseName}");
            expect($p->getMethod()->value)->toBe('DELETE');

            return MockResponse::make('', 204);
        },
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $response = $sdk->mySqlDatabases()->deleteDatabase($databaseName);

    expect($response->status())->toBe(204);
});

// ============================================================================
// GetDatabaseUsers Tests
// ============================================================================

it('builds GET /mysqldatabases/{databaseName}/users', function () {
    $databaseName = 'test_db';

    $mock = new MockClient([
        GetDatabaseUsers::class => function (PendingRequest $p) use ($databaseName) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe("/v2/mysqldatabases/{$databaseName}/users");
            expect($p->getMethod()->value)->toBe('GET');

            return MockResponse::make('[]', 200, [
                'Content-Type' => 'application/json',
            ]);
        },
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $sdk->mySqlDatabases()->getDatabaseUsers($databaseName);
});

it('maps GetDatabaseUsers to MySqlUser DTO list', function () {
    $mockData = [
        ['name' => 'user_one', 'rights' => 'read_write', 'enabled' => true],
        ['name' => 'user_two', 'rights' => 'read_only', 'enabled' => false],
    ];

    $mock = new MockClient([
        GetDatabaseUsers::class => MockResponse::make(json_encode($mockData), 200, [
            'Content-Type' => 'application/json',
        ]),
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $response = $sdk->mySqlDatabases()->getDatabaseUsers('test_db');

    /** @var MySqlUser[] $users */
    $users = $response->dto();

    expect($users)->toBeArray();
    expect($users)->toHaveCount(2);
    expect($users[0])->toBeInstanceOf(MySqlUser::class);
    expect($users[0]->name)->toBe('user_one');
    expect($users[0]->rights)->toBe('read_write');
    expect($users[0]->enabled)->toBe(true);
    expect($users[1]->name)->toBe('user_two');
    expect($users[1]->enabled)->toBe(false);
});

// ============================================================================
// CreateMySqlUser Tests
// ============================================================================

it('builds POST /mysqldatabases/{databaseName}/users with JSON body', function () {
    $databaseName = 'test_db';

    $mock = new MockClient([
        CreateMySqlUser::class => function (PendingRequest $p) use ($databaseName) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe("/v2/mysqldatabases/{$databaseName}/users");
            expect($p->getMethod()->value)->toBe('POST');

            $body = $p->body()->all();
            expect($body)->toMatchArray([
                'name' => 'new_user',
                'password' => 'UserP@ss456',
            ]);

            return MockResponse::make('', 201, [
                'Content-Type' => 'application/json',
            ]);
        },
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $request = new CreateMySqlUser($databaseName);
    $request->body()->merge([
        'name' => 'new_user',
        'password' => 'UserP@ss456',
    ]);
    $response = $sdk->send($request);

    expect($response->status())->toBe(201);
});

// ============================================================================
// ChangeDatabaseUserStatus Tests
// ============================================================================

it('builds PUT /mysqldatabases/{databaseName}/users/{userName}/status', function () {
    $databaseName = 'test_db';
    $userName = 'test_user';

    $mock = new MockClient([
        ChangeDatabaseUserStatus::class => function (PendingRequest $p) use ($databaseName, $userName) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe("/v2/mysqldatabases/{$databaseName}/users/{$userName}/status");
            expect($p->getMethod()->value)->toBe('PUT');

            return MockResponse::make('', 200);
        },
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $response = $sdk->mySqlDatabases()->changeDatabaseUserStatus($databaseName, $userName);

    expect($response->status())->toBe(200);
});

// ============================================================================
// ChangeDatabaseUserPassword Tests
// ============================================================================

it('builds PUT /mysqldatabases/{databaseName}/users/{userName}/password', function () {
    $databaseName = 'test_db';
    $userName = 'test_user';

    $mock = new MockClient([
        ChangeDatabaseUserPassword::class => function (PendingRequest $p) use ($databaseName, $userName) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe("/v2/mysqldatabases/{$databaseName}/users/{$userName}/password");
            expect($p->getMethod()->value)->toBe('PUT');

            return MockResponse::make('', 200);
        },
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $response = $sdk->mySqlDatabases()->changeDatabaseUserPassword($databaseName, $userName);

    expect($response->status())->toBe(200);
});

// ============================================================================
// DeleteDatabaseUser Tests
// ============================================================================

it('builds DELETE /mysqldatabases/{databaseName}/users/{userName}', function () {
    $databaseName = 'test_db';
    $userName = 'user_to_delete';

    $mock = new MockClient([
        DeleteDatabaseUser::class => function (PendingRequest $p) use ($databaseName, $userName) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe("/v2/mysqldatabases/{$databaseName}/users/{$userName}");
            expect($p->getMethod()->value)->toBe('DELETE');

            return MockResponse::make('', 204);
        },
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $response = $sdk->mySqlDatabases()->deleteDatabaseUser($databaseName, $userName);

    expect($response->status())->toBe(204);
});

// ============================================================================
// Edge Cases
// ============================================================================

it('handles database names with special characters', function () {
    $databaseName = 'test_db_123';

    $mock = new MockClient([
        GetMySqlDatabase::class => function (PendingRequest $p) use ($databaseName) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe("/v2/mysqldatabases/{$databaseName}");

            return MockResponse::make('{}', 200, [
                'Content-Type' => 'application/json',
            ]);
        },
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $sdk->mySqlDatabases()->getMySqlDatabase($databaseName);
});

it('handles empty database list', function () {
    $mock = new MockClient([
        GetMySqlDatabases::class => MockResponse::make('[]', 200, [
            'Content-Type' => 'application/json',
        ]),
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $response = $sdk->mySqlDatabases()->getMySqlDatabases();

    $databases = $response->dto();
    expect($databases)->toBeArray();
    expect($databases)->toHaveCount(0);
});

it('handles empty user list', function () {
    $mock = new MockClient([
        GetDatabaseUsers::class => MockResponse::make('[]', 200, [
            'Content-Type' => 'application/json',
        ]),
    ]);

    $sdk = Combell::fake($mock, 'k', 's');
    $response = $sdk->mySqlDatabases()->getDatabaseUsers('test_db');

    $users = $response->dto();
    expect($users)->toBeArray();
    expect($users)->toHaveCount(0);
});
