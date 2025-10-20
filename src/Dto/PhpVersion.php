<?php

namespace Joehoel\Combell\Dto;

class PhpVersion
{
    public function __construct(
        public ?string $version = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            version: $data['version'] ?? null,
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }
}
