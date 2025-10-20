<?php

namespace Joehoel\Combell\Dto;

class CatchAll
{
    public function __construct(
        public ?array $emailAddresses = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            emailAddresses: $data['email_addresses'] ?? [],
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }
}
