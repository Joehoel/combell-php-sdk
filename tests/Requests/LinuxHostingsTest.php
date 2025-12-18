<?php

use Joehoel\Combell\Combell;
use Joehoel\Combell\Dto\LinuxHosting;
use Joehoel\Combell\Dto\LinuxHostingDetail;
use Joehoel\Combell\Dto\PhpVersion;
use Joehoel\Combell\Dto\ScheduledTask;
use Joehoel\Combell\Dto\SshKey;
use Joehoel\Combell\Requests\LinuxHostings\AddScheduledTasks;
use Joehoel\Combell\Requests\LinuxHostings\AddSshKey;
use Joehoel\Combell\Requests\LinuxHostings\ChangeApcu;
use Joehoel\Combell\Requests\LinuxHostings\ChangeAutoRedirect;
use Joehoel\Combell\Requests\LinuxHostings\ChangeGzipCompression;
use Joehoel\Combell\Requests\LinuxHostings\ChangeLetsEncrypt;
use Joehoel\Combell\Requests\LinuxHostings\ChangePhpMemoryLimit;
use Joehoel\Combell\Requests\LinuxHostings\ChangePhpVersion;
use Joehoel\Combell\Requests\LinuxHostings\ConfigureFtp;
use Joehoel\Combell\Requests\LinuxHostings\ConfigureHttp2;
use Joehoel\Combell\Requests\LinuxHostings\ConfigureScheduledTask;
use Joehoel\Combell\Requests\LinuxHostings\ConfigureSsh;
use Joehoel\Combell\Requests\LinuxHostings\CreateHostHeader;
use Joehoel\Combell\Requests\LinuxHostings\CreateSubsite;
use Joehoel\Combell\Requests\LinuxHostings\DeleteScheduledTask;
use Joehoel\Combell\Requests\LinuxHostings\DeleteSshKey;
use Joehoel\Combell\Requests\LinuxHostings\DeleteSubsite;
use Joehoel\Combell\Requests\LinuxHostings\GetAvailablePhpVersions;
use Joehoel\Combell\Requests\LinuxHostings\GetLinuxHosting;
use Joehoel\Combell\Requests\LinuxHostings\GetLinuxHostings;
use Joehoel\Combell\Requests\LinuxHostings\GetScheduledTask;
use Joehoel\Combell\Requests\LinuxHostings\GetScheduledTasks;
use Joehoel\Combell\Requests\LinuxHostings\GetSshKeys;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\PendingRequest;

// ============================================================================
// Listing requests
// ============================================================================

it('maps GetLinuxHostings to LinuxHosting DTO list', function () {
    $mockClient = new MockClient([
        GetLinuxHostings::class => MockResponse::make(
            body: json_encode([
                ['domain_name' => 'example.com', 'servicepack_id' => 123],
                ['domain_name' => 'test.be', 'servicepack_id' => 456],
            ]),
            status: 200,
            headers: ['Content-Type' => 'application/json'],
        ),
    ]);

    $sdk = Combell::fake($mockClient);
    $response = $sdk->linuxHostings()->getLinuxHostings();

    /** @var LinuxHosting[] $hostings */
    $hostings = $response->dto();

    expect($hostings)->toBeArray();
    expect($hostings)->toHaveCount(2);
    expect($hostings[0])->toBeInstanceOf(LinuxHosting::class);
    expect($hostings[0]->domainName)->toBe('example.com');
    expect($hostings[0]->servicepackId)->toBe(123);
});

it('builds GET /linuxhostings with pagination query params', function () {
    $mock = new MockClient([
        GetLinuxHostings::class => function (PendingRequest $p) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe('/v2/linuxhostings');
            expect((string) $uri->getQuery())->toContain('skip=5');
            expect((string) $uri->getQuery())->toContain('take=10');

            return MockResponse::make('[]', 200, [
                'Content-Type' => 'application/json',
            ]);
        },
    ]);

    $sdk = Combell::fake($mock);
    $sdk->linuxHostings()->getLinuxHostings(skip: 5, take: 10);
});

// ============================================================================
// Detail and enumeration mappings
// ============================================================================

it('maps GetLinuxHosting to LinuxHostingDetail DTO', function () {
    $domainName = 'full.example';
    $mockData = [
        'domain_name' => $domainName,
        'servicepack_id' => 999,
        'max_webspace_size' => 1073741824,
        'max_size' => 2147483648,
        'webspace_usage' => 536870912,
        'actual_size' => 600000000,
        'ip' => '198.51.100.10',
        'ip_type' => 'IPv4',
        'ftp_enabled' => true,
        'ftp_username' => 'ftp-user',
        'ssh_host' => 'ssh.example.com',
        'ssh_username' => 'ssh-user',
        'php_version' => '8.2',
        'sites' => [
            ['name' => 'site-a', 'path' => '/site-a', 'ssl_enabled' => true],
        ],
        'mysql_database_names' => ['db_one', 'db_two'],
    ];

    $mock = new MockClient([
        GetLinuxHosting::class => MockResponse::make(json_encode($mockData), 200, [
            'Content-Type' => 'application/json',
        ]),
    ]);

    $sdk = Combell::fake($mock);
    $response = $sdk->linuxHostings()->getLinuxHosting($domainName);

    /** @var LinuxHostingDetail $detail */
    $detail = $response->dto();

    expect($detail)->toBeInstanceOf(LinuxHostingDetail::class);
    expect($detail->domainName)->toBe($domainName);
    expect($detail->phpVersion)->toBe('8.2');
    expect($detail->sites)->toHaveCount(1);
    expect($detail->mysqlDatabaseNames)->toMatchArray(['db_one', 'db_two']);
});

it('maps GetAvailablePhpVersions to PhpVersion DTO list', function () {
    $domainName = 'php.example';

    $mock = new MockClient([
        GetAvailablePhpVersions::class => MockResponse::make(json_encode([
            ['version' => '8.1'],
            ['version' => '8.2'],
        ]), 200, ['Content-Type' => 'application/json']),
    ]);

    $sdk = Combell::fake($mock);
    $response = $sdk->linuxHostings()->getAvailablePhpVersions($domainName);

    /** @var PhpVersion[] $versions */
    $versions = $response->dto();

    expect($versions)->toBeArray();
    expect($versions)->toHaveCount(2);
    expect($versions[0])->toBeInstanceOf(PhpVersion::class);
    expect($versions[1]->version)->toBe('8.2');
});

it('maps GetScheduledTasks to ScheduledTask DTO list', function () {
    $domainName = 'cron.example';

    $mock = new MockClient([
        GetScheduledTasks::class => MockResponse::make(json_encode([
            ['id' => 'task1', 'enabled' => true, 'cron_expression' => '* * * * *', 'script_location' => '/cron/a.php'],
            ['id' => 'task2', 'enabled' => false, 'cron_expression' => '0 * * * *', 'script_location' => '/cron/b.php'],
        ]), 200, ['Content-Type' => 'application/json']),
    ]);

    $sdk = Combell::fake($mock);
    $response = $sdk->linuxHostings()->getScheduledTasks($domainName);

    /** @var ScheduledTask[] $tasks */
    $tasks = $response->dto();

    expect($tasks)->toHaveCount(2);
    expect($tasks[0])->toBeInstanceOf(ScheduledTask::class);
    expect($tasks[0]->cronExpression)->toBe('* * * * *');
});

it('maps GetScheduledTask to ScheduledTask DTO', function () {
    $domainName = 'cron.example';
    $taskId = 'task-123';

    $mock = new MockClient([
        GetScheduledTask::class => MockResponse::make(json_encode([
            'id' => $taskId,
            'enabled' => true,
            'cron_expression' => '*/5 * * * *',
            'script_location' => '/cron/run.php',
        ]), 200, ['Content-Type' => 'application/json']),
    ]);

    $sdk = Combell::fake($mock);
    $response = $sdk->linuxHostings()->getScheduledTask($domainName, $taskId);

    /** @var ScheduledTask $task */
    $task = $response->dto();

    expect($task)->toBeInstanceOf(ScheduledTask::class);
    expect($task->id)->toBe($taskId);
    expect($task->scriptLocation)->toBe('/cron/run.php');
});

it('maps GetSshKeys to SshKey DTO list', function () {
    $domainName = 'ssh.example';

    $mock = new MockClient([
        GetSshKeys::class => MockResponse::make(json_encode([
            ['fingerprint' => 'fp1', 'public_key' => 'ssh-rsa AAA'],
            ['fingerprint' => 'fp2', 'public_key' => 'ssh-ed25519 BBB'],
        ]), 200, ['Content-Type' => 'application/json']),
    ]);

    $sdk = Combell::fake($mock);
    $response = $sdk->linuxHostings()->getSshKeys($domainName);

    /** @var SshKey[] $keys */
    $keys = $response->dto();

    expect($keys)->toHaveCount(2);
    expect($keys[1])->toBeInstanceOf(SshKey::class);
    expect($keys[1]->fingerprint)->toBe('fp2');
});

// ============================================================================
// Mutating requests
// ============================================================================

it('builds POST /linuxhostings/{domain}/subsites with JSON body', function () {
    $domainName = 'example.com';

    $mock = new MockClient([
        CreateSubsite::class => function (PendingRequest $p) use ($domainName) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe("/v2/linuxhostings/{$domainName}/subsites");
            expect($p->getMethod()->value)->toBe('POST');

            $body = $p->body()->all();
            expect($body)->toMatchArray([
                'name' => 'blog',
                'path' => '/blog',
            ]);

            return MockResponse::make('', 201, ['Content-Type' => 'application/json']);
        },
    ]);

    $sdk = Combell::fake($mock);
    $request = new CreateSubsite($domainName);
    $request->body()->merge(['name' => 'blog', 'path' => '/blog']);
    $response = $sdk->send($request);

    expect($response->status())->toBe(201);
});

it('builds DELETE /linuxhostings/{domain}/subsites/{site}', function () {
    $domainName = 'example.com';
    $siteName = 'old-site';

    $mock = new MockClient([
        DeleteSubsite::class => function (PendingRequest $p) use ($domainName, $siteName) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe("/v2/linuxhostings/{$domainName}/subsites/{$siteName}");
            expect($p->getMethod()->value)->toBe('DELETE');

            return MockResponse::make('', 204);
        },
    ]);

    $sdk = Combell::fake($mock);
    $response = $sdk->linuxHostings()->deleteSubsite($domainName, $siteName);

    expect($response->status())->toBe(204);
});

it('builds POST /linuxhostings/{domain}/sites/{site}/hostheaders with JSON body', function () {
    $domainName = 'example.com';
    $siteName = 'www';

    $mock = new MockClient([
        CreateHostHeader::class => function (PendingRequest $p) use ($domainName, $siteName) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe("/v2/linuxhostings/{$domainName}/sites/{$siteName}/hostheaders");
            expect($p->getMethod()->value)->toBe('POST');

            $body = $p->body()->all();
            expect($body)->toMatchArray([
                'hostname' => 'api.example.com',
            ]);

            return MockResponse::make('', 201, ['Content-Type' => 'application/json']);
        },
    ]);

    $sdk = Combell::fake($mock);
    $request = new CreateHostHeader($domainName, $siteName);
    $request->body()->merge(['hostname' => 'api.example.com']);
    $response = $sdk->send($request);

    expect($response->status())->toBe(201);
});

it('builds PUT /linuxhostings/{domain}/sites/{site}/http2/configuration', function () {
    $domainName = 'example.com';
    $siteName = 'www';

    $mock = new MockClient([
        ConfigureHttp2::class => function (PendingRequest $p) use ($domainName, $siteName) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe("/v2/linuxhostings/{$domainName}/sites/{$siteName}/http2/configuration");
            expect($p->getMethod()->value)->toBe('PUT');

            return MockResponse::make('', 200);
        },
    ]);

    $sdk = Combell::fake($mock);
    $response = $sdk->linuxHostings()->configureHttp2($domainName, $siteName);

    expect($response->status())->toBe(200);
});

it('builds PUT /linuxhostings/{domain}/ftp/configuration', function () {
    $domainName = 'example.com';

    $mock = new MockClient([
        ConfigureFtp::class => function (PendingRequest $p) use ($domainName) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe("/v2/linuxhostings/{$domainName}/ftp/configuration");
            expect($p->getMethod()->value)->toBe('PUT');

            return MockResponse::make('', 200);
        },
    ]);

    $sdk = Combell::fake($mock);
    $response = $sdk->linuxHostings()->configureFtp($domainName);

    expect($response->status())->toBe(200);
});

it('builds PUT /linuxhostings/{domain}/sslsettings/{hostname}/letsencrypt', function () {
    $mock = new MockClient([
        ChangeLetsEncrypt::class => function (PendingRequest $p) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe('/v2/linuxhostings/domain.com/sslsettings/www.domain.com/letsencrypt');
            expect($p->getMethod()->value)->toBe('PUT');

            return MockResponse::make('', 200);
        },
    ]);

    $sdk = Combell::fake($mock);
    $response = $sdk->linuxHostings()->changeLetsEncrypt('domain.com', 'www.domain.com');

    expect($response->status())->toBe(200);
});

it('builds PUT /linuxhostings/{domain}/sslsettings/{hostname}/autoredirect', function () {
    $mock = new MockClient([
        ChangeAutoRedirect::class => function (PendingRequest $p) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe('/v2/linuxhostings/domain.com/sslsettings/www.domain.com/autoredirect');
            expect($p->getMethod()->value)->toBe('PUT');

            return MockResponse::make('', 200);
        },
    ]);

    $sdk = Combell::fake($mock);
    $response = $sdk->linuxHostings()->changeAutoRedirect('domain.com', 'www.domain.com');

    expect($response->status())->toBe(200);
});

it('builds PUT /linuxhostings/{domain}/phpsettings/version', function () {
    $domainName = 'example.com';

    $mock = new MockClient([
        ChangePhpVersion::class => function (PendingRequest $p) use ($domainName) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe("/v2/linuxhostings/{$domainName}/phpsettings/version");
            expect($p->getMethod()->value)->toBe('PUT');

            return MockResponse::make('', 200);
        },
    ]);

    $sdk = Combell::fake($mock);
    $response = $sdk->linuxHostings()->changePhpVersion($domainName);

    expect($response->status())->toBe(200);
});

it('builds PUT /linuxhostings/{domain}/settings/gzipcompression', function () {
    $domainName = 'example.com';

    $mock = new MockClient([
        ChangeGzipCompression::class => function (PendingRequest $p) use ($domainName) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe("/v2/linuxhostings/{$domainName}/settings/gzipcompression");
            expect($p->getMethod()->value)->toBe('PUT');

            return MockResponse::make('', 200);
        },
    ]);

    $sdk = Combell::fake($mock);
    $response = $sdk->linuxHostings()->changeGzipCompression($domainName);

    expect($response->status())->toBe(200);
});

it('builds PUT /linuxhostings/{domain}/phpsettings/memorylimit', function () {
    $domainName = 'example.com';

    $mock = new MockClient([
        ChangePhpMemoryLimit::class => function (PendingRequest $p) use ($domainName) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe("/v2/linuxhostings/{$domainName}/phpsettings/memorylimit");
            expect($p->getMethod()->value)->toBe('PUT');

            return MockResponse::make('', 200);
        },
    ]);

    $sdk = Combell::fake($mock);
    $response = $sdk->linuxHostings()->changePhpMemoryLimit($domainName);

    expect($response->status())->toBe(200);
});

it('builds PUT /linuxhostings/{domain}/phpsettings/apcu', function () {
    $domainName = 'example.com';

    $mock = new MockClient([
        ChangeApcu::class => function (PendingRequest $p) use ($domainName) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe("/v2/linuxhostings/{$domainName}/phpsettings/apcu");
            expect($p->getMethod()->value)->toBe('PUT');

            return MockResponse::make('', 200);
        },
    ]);

    $sdk = Combell::fake($mock);
    $response = $sdk->linuxHostings()->changeApcu($domainName);

    expect($response->status())->toBe(200);
});

it('builds POST /linuxhostings/{domain}/scheduledtasks with JSON body', function () {
    $domainName = 'example.com';

    $mock = new MockClient([
        AddScheduledTasks::class => function (PendingRequest $p) use ($domainName) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe("/v2/linuxhostings/{$domainName}/scheduledtasks");
            expect($p->getMethod()->value)->toBe('POST');

            $body = $p->body()->all();
            expect($body)->toMatchArray([
                'tasks' => [
                    ['name' => 'task1', 'cron' => '* * * * *'],
                ],
            ]);

            return MockResponse::make('', 202, ['Content-Type' => 'application/json']);
        },
    ]);

    $sdk = Combell::fake($mock);
    $request = new AddScheduledTasks($domainName);
    $request->body()->merge([
        'tasks' => [
            ['name' => 'task1', 'cron' => '* * * * *'],
        ],
    ]);
    $response = $sdk->send($request);

    expect($response->status())->toBe(202);
});

it('builds PUT /linuxhostings/{domain}/scheduledtasks/{id}', function () {
    $domainName = 'example.com';
    $taskId = 'abc123';

    $mock = new MockClient([
        ConfigureScheduledTask::class => function (PendingRequest $p) use ($domainName, $taskId) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe("/v2/linuxhostings/{$domainName}/scheduledtasks/{$taskId}");
            expect($p->getMethod()->value)->toBe('PUT');

            return MockResponse::make('', 200);
        },
    ]);

    $sdk = Combell::fake($mock);
    $response = $sdk->linuxHostings()->configureScheduledTask($domainName, $taskId);

    expect($response->status())->toBe(200);
});

it('builds DELETE /linuxhostings/{domain}/scheduledtasks/{id}', function () {
    $domainName = 'example.com';
    $taskId = 'abc123';

    $mock = new MockClient([
        DeleteScheduledTask::class => function (PendingRequest $p) use ($domainName, $taskId) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe("/v2/linuxhostings/{$domainName}/scheduledtasks/{$taskId}");
            expect($p->getMethod()->value)->toBe('DELETE');

            return MockResponse::make('', 204);
        },
    ]);

    $sdk = Combell::fake($mock);
    $response = $sdk->linuxHostings()->deleteScheduledTask($domainName, $taskId);

    expect($response->status())->toBe(204);
});

it('builds POST /linuxhostings/{domain}/ssh/keys with JSON body', function () {
    $domainName = 'example.com';

    $mock = new MockClient([
        AddSshKey::class => function (PendingRequest $p) use ($domainName) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe("/v2/linuxhostings/{$domainName}/ssh/keys");
            expect($p->getMethod()->value)->toBe('POST');

            $body = $p->body()->all();
            expect($body)->toMatchArray([
                'public_key' => 'ssh-ed25519 AAAA',
            ]);

            return MockResponse::make('', 201, ['Content-Type' => 'application/json']);
        },
    ]);

    $sdk = Combell::fake($mock);
    $request = new AddSshKey($domainName);
    $request->body()->merge(['public_key' => 'ssh-ed25519 AAAA']);
    $response = $sdk->send($request);

    expect($response->status())->toBe(201);
});

it('builds PUT /linuxhostings/{domain}/ssh/configuration', function () {
    $domainName = 'example.com';

    $mock = new MockClient([
        ConfigureSsh::class => function (PendingRequest $p) use ($domainName) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe("/v2/linuxhostings/{$domainName}/ssh/configuration");
            expect($p->getMethod()->value)->toBe('PUT');

            return MockResponse::make('', 200);
        },
    ]);

    $sdk = Combell::fake($mock);
    $response = $sdk->linuxHostings()->configureSsh($domainName);

    expect($response->status())->toBe(200);
});

it('builds DELETE /linuxhostings/{domain}/ssh/keys/{fingerprint}', function () {
    $domainName = 'example.com';
    $fingerprint = 'fp-123';

    $mock = new MockClient([
        DeleteSshKey::class => function (PendingRequest $p) use ($domainName, $fingerprint) {
            $uri = $p->getUri();
            expect((string) $uri->getPath())->toBe("/v2/linuxhostings/{$domainName}/ssh/keys/{$fingerprint}");
            expect($p->getMethod()->value)->toBe('DELETE');

            return MockResponse::make('', 204);
        },
    ]);

    $sdk = Combell::fake($mock);
    $response = $sdk->linuxHostings()->deleteSshKey($domainName, $fingerprint);

    expect($response->status())->toBe(204);
});
