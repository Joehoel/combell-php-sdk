<?php

namespace Joehoel\Combell\Dto;

class WindowsSite
{
    public function __construct(
        public ?string $name = null,
        public ?string $path = null,
        public ?array $bindings = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            name: $data['name'] ?? null,
            path: $data['path'] ?? null,
            bindings: $data['bindings'] ?? [],
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }
}
