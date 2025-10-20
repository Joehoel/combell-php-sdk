<?php

namespace Joehoel\Combell\Dto;


class AddSshKeyRequest
{
    public function __construct(
public ?string $publicKey = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            publicKey: $data['public_key'] ?? null,
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }

}
