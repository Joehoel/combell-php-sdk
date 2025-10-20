<?php

namespace Joehoel\Combell\Dto;


class UpdatePhpApcuRequest
{
    public function __construct(
public ?int $apcuSize = null,
        public ?bool $enabled = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            apcuSize: $data['apcu_size'] ?? null,
            enabled: $data['enabled'] ?? null,
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }

}
