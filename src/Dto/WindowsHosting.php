<?php

namespace Joehoel\Combell\Dto;

class WindowsHosting
{
    public function __construct(
        public ?string $domainName = null,
        public ?int $servicepackId = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            domainName: $data['domain_name'] ?? null,
            servicepackId: $data['servicepack_id'] ?? null,
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }
}
