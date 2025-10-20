<?php

namespace Joehoel\Combell\Dto;

class CreateMailboxRequest
{
    public function __construct(
        public ?string $emailAddress = null,
        public ?int $accountId = null,
        public ?string $password = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            emailAddress: $data['email_address'] ?? null,
            accountId: $data['account_id'] ?? null,
            password: $data['password'] ?? null,
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }
}
