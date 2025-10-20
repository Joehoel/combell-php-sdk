<?php

namespace Joehoel\Combell\Dto;

/**
 * A site binding identifies a web domain.
 */
class SiteBinding
{
    public function __construct(
        public ?string $protocol = null,
        public ?string $hostName = null,
        public ?string $ipAddress = null,
        public ?int $port = null,
        public ?string $certThumbprint = null,
        public ?bool $sslEnabled = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            protocol: $data['protocol'] ?? null,
            hostName: $data['host_name'] ?? null,
            ipAddress: $data['ip_address'] ?? null,
            port: $data['port'] ?? null,
            certThumbprint: $data['cert_thumbprint'] ?? null,
            sslEnabled: $data['ssl_enabled'] ?? null,
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }
}
