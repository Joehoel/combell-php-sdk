<?php

namespace Joehoel\Combell\Dto;


class CompletionEstimation
{
    public function __construct(
        public ?string $estimate = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            estimate: $data['estimate'] ?? null,
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }

}
