<?php

namespace Joehoel\Combell\Dto;

class SshKeyDetail
{
    public function __construct(
        public ?string $fingerprint = null,
        public ?string $publicKey = null,
        public ?array $linuxHostings = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            fingerprint: $data['fingerprint'] ?? null,
            publicKey: $data['public_key'] ?? null,
            linuxHostings: $data['linux_hostings'] ?? [],
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }
}
