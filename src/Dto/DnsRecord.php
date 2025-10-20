<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class DnsRecord extends SpatieData
{
    public function __construct(
        public ?string $id = null,
        public ?string $type = null,
        #[MapName('record_name')]
        public ?string $recordName = null,
        public ?int $ttl = null,
        public ?string $content = null,
        public ?int $priority = null,
        public ?string $service = null,
        public ?int $weight = null,
        public ?string $target = null,
        public ?string $protocol = null,
        public ?int $port = null,
    ) {}
}
