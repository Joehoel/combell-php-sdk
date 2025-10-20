<?php

namespace Joehoel\Combell;

use Saloon\Http\Connector;
use Saloon\Http\Faking\MockClient;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

class Combell extends Connector
{
    use AlwaysThrowOnErrors;

    public function __construct(
        protected string $apiKey,
        protected string $apiSecret,
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
            apiKey: $apiKey ?? '',
            apiSecret: $apiSecret ?? '',
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
}
