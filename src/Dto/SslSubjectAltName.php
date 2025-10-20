<?php

namespace Joehoel\Combell\Dto;

class SslSubjectAltName
{
    public function __construct(
        public ?string $type = null,
        public ?string $value = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            type: $data['type'] ?? null,
            value: $data['value'] ?? null,
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }
}
