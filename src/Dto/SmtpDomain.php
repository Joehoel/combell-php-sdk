<?php

namespace Joehoel\Combell\Dto;

class SmtpDomain
{
    public function __construct(
        public ?string $hostname = null,
        public ?bool $enabled = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            hostname: $data['hostname'] ?? null,
            enabled: $data['enabled'] ?? null,
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }
}
