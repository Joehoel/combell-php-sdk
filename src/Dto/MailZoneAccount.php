<?php

namespace Joehoel\Combell\Dto;


class MailZoneAccount
{
    public function __construct(
public ?int $accountId = null,
        public ?int $size = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            accountId: $data['account_id'] ?? null,
            size: $data['size'] ?? null,
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }

}
