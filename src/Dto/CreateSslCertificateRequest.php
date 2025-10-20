<?php

namespace Joehoel\Combell\Dto;

class CreateSslCertificateRequest
{
    public function __construct(
        public ?string $csr = null,
        public ?string $certificateType = null,
        public ?string $validationLevel = null,
        public ?array $additionalValidationAttributes = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            csr: $data['csr'] ?? null,
            certificateType: $data['certificate_type'] ?? null,
            validationLevel: $data['validation_level'] ?? null,
            additionalValidationAttributes: $data['additional_validation_attributes'] ?? [],
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }
}
