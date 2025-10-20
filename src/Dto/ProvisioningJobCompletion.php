<?php

namespace Joehoel\Combell\Dto;


class ProvisioningJobCompletion
{
    public function __construct(
        public ?string $id = null,
public ?array $resourceLinks = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            resourceLinks: $data['resource_links'] ?? [],
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }

}
