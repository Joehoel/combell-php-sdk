<?php

namespace Joehoel\Combell\Dto;

/**
 * Servicepack information.
 */
class Servicepack
{
    public function __construct(
        public ?int $id = null,
        public ?string $name = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            name: $data['name'] ?? null,
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }
}
