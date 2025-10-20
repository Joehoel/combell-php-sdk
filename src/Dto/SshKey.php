<?php

namespace Joehoel\Combell\Dto;


class SshKey
{
    public function __construct(
        public ?string $fingerprint = null,
public ?string $publicKey = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            fingerprint: $data['fingerprint'] ?? null,
            publicKey: $data['public_key'] ?? null,
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }

}
