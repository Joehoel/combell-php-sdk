<?php

namespace Joehoel\Combell\Dto;

class NameServer
{
    public function __construct(
        public ?string $name = null,
        public ?string $ip = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            name: $data['name'] ?? null,
            ip: $data['ip'] ?? null,
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }
}
