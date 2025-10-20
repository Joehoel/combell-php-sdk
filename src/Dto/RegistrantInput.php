<?php

namespace Joehoel\Combell\Dto;

class RegistrantInput
{
    public function __construct(
        public ?string $firstName = null,
        public ?string $lastName = null,
        public ?string $address = null,
        public ?string $postalCode = null,
        public ?string $city = null,
        public ?string $countryCode = null,
        public ?string $email = null,
        public ?string $fax = null,
        public ?string $phone = null,
        public ?string $languageCode = null,
        public ?string $companyName = null,
        public ?string $enterpriseNumber = null,
        public ?array $extraFields = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            firstName: $data['first_name'] ?? null,
            lastName: $data['last_name'] ?? null,
            address: $data['address'] ?? null,
            postalCode: $data['postal_code'] ?? null,
            city: $data['city'] ?? null,
            countryCode: $data['country_code'] ?? null,
            email: $data['email'] ?? null,
            fax: $data['fax'] ?? null,
            phone: $data['phone'] ?? null,
            languageCode: $data['language_code'] ?? null,
            companyName: $data['company_name'] ?? null,
            enterpriseNumber: $data['enterprise_number'] ?? null,
            extraFields: $data['extra_fields'] ?? [],
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }
}
