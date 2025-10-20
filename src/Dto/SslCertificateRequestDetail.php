<?php

namespace Joehoel\Combell\Dto;


class SslCertificateRequestDetail
{
    public function __construct(
        public ?int $id = null,
public ?string $certificateType = null,
public ?string $validationLevel = null,
        public ?string $vendor = null,
public ?string $commonName = null,
public ?string $orderCode = null,
public ?array $subjectAltNames = null,
        public ?array $validations = null,
public ?string $providerPortalUrl = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            certificateType: $data['certificate_type'] ?? null,
            validationLevel: $data['validation_level'] ?? null,
            vendor: $data['vendor'] ?? null,
            commonName: $data['common_name'] ?? null,
            orderCode: $data['order_code'] ?? null,
            subjectAltNames: $data['subject_alt_names'] ?? [],
            validations: $data['validations'] ?? [],
            providerPortalUrl: $data['provider_portal_url'] ?? null,
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }

}
