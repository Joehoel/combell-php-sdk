<?php

namespace Joehoel\Combell\Dto;


class MySqlDatabase
{
    public function __construct(
        public ?string $name = null,
        public ?string $hostname = null,
public ?int $userCount = null,
public ?int $maxSize = null,
public ?int $actualSize = null,
public ?int $accountId = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            name: $data['name'] ?? null,
            hostname: $data['hostname'] ?? null,
            userCount: $data['user_count'] ?? null,
            maxSize: $data['max_size'] ?? null,
            actualSize: $data['actual_size'] ?? null,
            accountId: $data['account_id'] ?? null,
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }

}
