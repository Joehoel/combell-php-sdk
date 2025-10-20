<?php

namespace Joehoel\Combell\Dto;


/**
 * A detailed representation of an account.
 */
class AccountDetail
{
    public function __construct(
        public ?int $id = null,
        public ?string $identifier = null,
        public ?object $servicepack = null,
        public ?array $addons = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            identifier: $data['identifier'] ?? null,
            servicepack: $data['servicepack'] ?? null,
            addons: $data['addons'] ?? [],
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }

}
