<?php

namespace Joehoel\Combell\Dto;


class ProvisioningJobInfo
{
    public function __construct(
        public ?string $id = null,
        public ?string $status = null,
        public ?object $completion = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            status: $data['status'] ?? null,
            completion: $data['completion'] ?? null,
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }

}
