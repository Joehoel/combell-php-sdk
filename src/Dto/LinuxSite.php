<?php

namespace Joehoel\Combell\Dto;


class LinuxSite
{
    public function __construct(
        public ?string $name = null,
        public ?string $path = null,
public ?array $hostHeaders = null,
public ?bool $sslEnabled = null,
public ?bool $httpsRedirectEnabled = null,
public ?bool $http2Enabled = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            name: $data['name'] ?? null,
            path: $data['path'] ?? null,
            hostHeaders: $data['host_headers'] ?? [],
            sslEnabled: $data['ssl_enabled'] ?? null,
            httpsRedirectEnabled: $data['https_redirect_enabled'] ?? null,
            http2Enabled: $data['http2_enabled'] ?? null,
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }

}
