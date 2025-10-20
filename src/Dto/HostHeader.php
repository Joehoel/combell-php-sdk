<?php

namespace Joehoel\Combell\Dto;

/**
 * A host header identifies a web domain.
 */
class HostHeader
{
    public function __construct(
        public ?string $name = null,
        public ?bool $enabled = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            name: $data['name'] ?? null,
            enabled: $data['enabled'] ?? null,
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }
}
