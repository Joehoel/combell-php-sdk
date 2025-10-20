<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

/**
 * A site binding identifies a web domain.
 */
class SiteBinding extends SpatieData
{
    public function __construct(
        public ?string $protocol = null,
        #[MapName('host_name')]
        public ?string $hostName = null,
        #[MapName('ip_address')]
        public ?string $ipAddress = null,
        public ?int $port = null,
        #[MapName('cert_thumbprint')]
        public ?string $certThumbprint = null,
        #[MapName('ssl_enabled')]
        public ?bool $sslEnabled = null,
    ) {}
}
