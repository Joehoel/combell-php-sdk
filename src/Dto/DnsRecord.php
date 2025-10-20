<?php

namespace Joehoel\Combell\Dto;


class DnsRecord
{
    public function __construct(
        public ?string $id = null,
        public ?string $type = null,
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

    public static function fromResponse(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            type: $data['type'] ?? null,
            recordName: $data['record_name'] ?? null,
            ttl: $data['ttl'] ?? null,
            content: $data['content'] ?? null,
            priority: $data['priority'] ?? null,
            service: $data['service'] ?? null,
            weight: $data['weight'] ?? null,
            target: $data['target'] ?? null,
            protocol: $data['protocol'] ?? null,
            port: $data['port'] ?? null,
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }

}
