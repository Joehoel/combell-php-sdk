<?php

namespace Joehoel\Combell\Dto;

class CreateMySqlDatabase
{
    public function __construct(
        public ?string $databaseName = null,
        public ?int $accountId = null,
        public ?string $password = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            databaseName: $data['database_name'] ?? null,
            accountId: $data['account_id'] ?? null,
            password: $data['password'] ?? null,
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }
}
