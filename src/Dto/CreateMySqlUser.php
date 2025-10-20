<?php

namespace Joehoel\Combell\Dto;

class CreateMySqlUser
{
    public function __construct(
        public ?string $name = null,
        public ?string $password = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            name: $data['name'] ?? null,
            password: $data['password'] ?? null,
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }
}
