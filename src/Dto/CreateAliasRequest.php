<?php

namespace Joehoel\Combell\Dto;


class CreateAliasRequest
{
    public function __construct(
public ?string $emailAddress = null,
        public ?array $destinations = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            emailAddress: $data['email_address'] ?? null,
            destinations: $data['destinations'] ?? [],
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }

}
