<?php

namespace Joehoel\Combell\Dto;


class UpdatePhpMemoryLimitRequest
{
    public function __construct(
public ?int $memoryLimit = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            memoryLimit: $data['memory_limit'] ?? null,
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }

}
