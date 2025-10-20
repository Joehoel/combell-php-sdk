<?php

namespace Joehoel\Combell\Dto;

class AdditionalValidationAttribute
{
    public function __construct(
        public ?string $name = null,
        public ?string $value = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            name: $data['name'] ?? null,
            value: $data['value'] ?? null,
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }
}
