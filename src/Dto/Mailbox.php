<?php

namespace Joehoel\Combell\Dto;

class Mailbox
{
    public function __construct(
        public ?string $name = null,
        public ?int $maxSize = null,
        public ?int $actualSize = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            name: $data['name'] ?? null,
            maxSize: $data['max_size'] ?? null,
            actualSize: $data['actual_size'] ?? null,
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }
}
