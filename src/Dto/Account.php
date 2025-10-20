<?php

namespace Joehoel\Combell\Dto;


class Account
{
    public function __construct(
        public ?int $id = null,
        public ?string $identifier = null,
public ?int $servicepackId = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            identifier: $data['identifier'] ?? null,
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }

}
