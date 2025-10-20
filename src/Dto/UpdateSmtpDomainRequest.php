<?php

namespace Joehoel\Combell\Dto;


class UpdateSmtpDomainRequest
{
    public function __construct(
        public ?bool $enabled = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            enabled: $data['enabled'] ?? null,
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }

}
