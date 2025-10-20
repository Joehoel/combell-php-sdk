<?php

namespace Joehoel\Combell\Dto;

class AutoForward
{
    public function __construct(
        public ?bool $enabled = null,
        public ?array $emailAddresses = null,
        public ?bool $copyToMyself = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            enabled: $data['enabled'] ?? null,
            emailAddresses: $data['email_addresses'] ?? [],
            copyToMyself: $data['copy_to_myself'] ?? null,
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }
}
