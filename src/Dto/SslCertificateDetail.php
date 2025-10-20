<?php

namespace Joehoel\Combell\Dto;

class SslCertificateDetail
{
    public function __construct(
        public ?string $sha1Fingerprint = null,
        public ?string $commonName = null,
        public ?string $expiresAfter = null,
        public ?string $validationLevel = null,
        public ?string $type = null,
        public ?array $subjectAltNames = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            sha1Fingerprint: $data['sha1_fingerprint'] ?? null,
            commonName: $data['common_name'] ?? null,
            expiresAfter: $data['expires_after'] ?? null,
            validationLevel: $data['validation_level'] ?? null,
            type: $data['type'] ?? null,
            subjectAltNames: $data['subject_alt_names'] ?? [],
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }
}
