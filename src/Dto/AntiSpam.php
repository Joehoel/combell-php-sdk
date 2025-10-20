<?php

namespace Joehoel\Combell\Dto;


class AntiSpam
{
    public function __construct(
        public ?string $type = null,
public ?array $allowedTypes = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            type: $data['type'] ?? null,
            allowedTypes: $data['allowed_types'] ?? [],
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }

}
