<?php

namespace Joehoel\Combell\Dto;


class UpdateAliasRequest
{
    public function __construct(
        public ?array $destinations = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            destinations: $data['destinations'] ?? [],
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }

}
