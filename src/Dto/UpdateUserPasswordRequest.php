<?php

namespace Joehoel\Combell\Dto;

class UpdateUserPasswordRequest
{
    public function __construct(
        public ?string $password = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            password: $data['password'] ?? null,
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }
}
