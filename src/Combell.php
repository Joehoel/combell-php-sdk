<?php

namespace Joehoel\Combell;

use Saloon\Http\Connector;
use Saloon\Http\Faking\MockClient;

use Joehoel\Combell\Resource\Accounts;
use Joehoel\Combell\Resource\DnsRecords;
use Joehoel\Combell\Resource\Domains;
use Joehoel\Combell\Resource\LinuxHostings;
use Joehoel\Combell\Resource\MailZones;
use Joehoel\Combell\Resource\Mailboxes;
use Joehoel\Combell\Resource\MySqlDatabases;
use Joehoel\Combell\Resource\ProvisioningJobs;
use Joehoel\Combell\Resource\Servicepacks;
use Joehoel\Combell\Resource\Ssh;
use Joehoel\Combell\Resource\SslCertificateRequests;
use Joehoel\Combell\Resource\SslCertificates;
use Joehoel\Combell\Resource\WindowsHostings;

class Combell extends Connector
{
    public function __construct(
        private string $apiKey,
        private string $apiSecret,
    ) {}

    public function resolveBaseUrl(): string
    {
        return 'https://api.combell.nl/v2/';
    }

    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    protected function defaultAuth(): HmacAuthenticator
    {
        return new HmacAuthenticator($this->apiKey, $this->apiSecret);
    }

    /**
     * Create a Combell connector pre-configured with a local MockClient.
     *
     * Usage:
     * - Provide an array of mocks (request class, URL wildcard, or connector class keys)
     * - Or provide an existing MockClient instance
     */
    public static function fake(
        MockClient|array $mock = [],
        ?string $apiKey = null,
        ?string $apiSecret = null,
    ): static {
        $instance = new static(
            apiKey: $apiKey ?? "",
            apiSecret: $apiSecret ?? "",
        );

        if ($mock instanceof MockClient) {
            $instance->withMockClient($mock);
        } else {
            $instance->withMockClient(new MockClient($mock));
        }

        return $instance;
    }

    /**
     * Register a global MockClient for all requests.
     *
     * Note: This will reset any existing global mock instance.
     */
    public static function fakeGlobal(array $mockData = []): MockClient
    {
        MockClient::destroyGlobal();

        return MockClient::global($mockData);
    }

    // ---
    public function accounts(): Accounts
    {
        return new Accounts($this);
    }

    public function dnsRecords(): DnsRecords
    {
        return new DnsRecords($this);
    }

    public function domains(): Domains
    {
        return new Domains($this);
    }

    public function linuxHostings(): LinuxHostings
    {
        return new LinuxHostings($this);
    }

    public function mailZones(): MailZones
    {
        return new MailZones($this);
    }

    public function mailboxes(): Mailboxes
    {
        return new Mailboxes($this);
    }

    public function mySqlDatabases(): MySqlDatabases
    {
        return new MySqlDatabases($this);
    }

    public function provisioningJobs(): ProvisioningJobs
    {
        return new ProvisioningJobs($this);
    }

    public function servicepacks(): Servicepacks
    {
        return new Servicepacks($this);
    }

    public function ssh(): Ssh
    {
        return new Ssh($this);
    }

    public function sslCertificateRequests(): SslCertificateRequests
    {
        return new SslCertificateRequests($this);
    }

    public function sslCertificates(): SslCertificates
    {
        return new SslCertificates($this);
    }

    public function windowsHostings(): WindowsHostings
    {
        return new WindowsHostings($this);
    }
}
