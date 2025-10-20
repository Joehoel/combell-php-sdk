<?php

namespace Joehoel\Combell\Dto;

class EditNameServers
{
    public function __construct(
        public ?string $domainName = null,
        public ?array $nameServers = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            domainName: $data['domain_name'] ?? null,
            nameServers: $data['name_servers'] ?? [],
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }
}
