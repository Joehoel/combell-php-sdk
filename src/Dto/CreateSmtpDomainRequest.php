<?php

namespace Joehoel\Combell\Dto;


class CreateSmtpDomainRequest
{
    public function __construct(
        public ?string $hostname = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            hostname: $data['hostname'] ?? null,
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }

}
