<?php

namespace Joehoel\Combell\Dto;


class UpdateAntiSpamRequest
{
    public function __construct(
        public ?string $type = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            type: $data['type'] ?? null,
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }

}
