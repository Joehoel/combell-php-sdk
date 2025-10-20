<?php

use Saloon\Http\Connector;
use Saloon\Http\Faking\MockClient;

class Combell extends Connector
{
    public function __construct(
        private string $apiKey,
        private string $apiSecret,
    ) {
        parent::__construct();
    }

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
     * Example:
     * $sdk = Combell::fake([
     *     'api.combell.nl/*' => \Saloon\Http\Faking\MockResponse::make(body: '{}', status: 200),
     * ]);
     */
    public static function fake(
        array $mockData = [],
        ?string $apiKey = null,
        ?string $apiSecret = null,
    ): static {
        $instance = new static(
            apiKey: $apiKey ?? "",
            apiSecret: $apiSecret ?? "",
        );
        $instance->withMockClient(new MockClient($mockData));

        return $instance;
    }

    /**
     * Register a global MockClient for all requests (remember to destroy after tests).
     */
    public static function fakeGlobal(array $mockData = []): MockClient
    {
        return MockClient::global($mockData);
    }
}
