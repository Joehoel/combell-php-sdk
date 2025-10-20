<?php

use Saloon\Http\Connector;

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
        return "https://api.combell.nl/v2/";
    }

    protected function defaultHeaders(): array
    {
        return [
            "Content-Type" => "application/json",
            "Accept" => "application/json",
        ];
    }

    protected function defaultAuth(): HmacAuthenticator
    {
        return new HmacAuthenticator($this->apiKey, $this->apiSecret);
    }
}
