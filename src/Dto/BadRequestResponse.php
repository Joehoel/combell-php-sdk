<?php

namespace Joehoel\Combell\Dto;

class BadRequestResponse
{
    public function __construct(
        public ?array $validationErrors = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            validationErrors: $data['validation_errors'] ?? [],
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }
}
