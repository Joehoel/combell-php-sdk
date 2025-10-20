<?php

namespace Joehoel\Combell\Dto;

class MySqlUser
{
    public function __construct(
        public ?string $name = null,
        public ?string $rights = null,
        public ?bool $enabled = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            name: $data['name'] ?? null,
            rights: $data['rights'] ?? null,
            enabled: $data['enabled'] ?? null,
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }
}
