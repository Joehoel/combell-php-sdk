<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class Registrant extends SpatieData
{
    public function __construct(
        #[MapName('first_name')]
        public ?string $firstName = null,
        #[MapName('last_name')]
        public ?string $lastName = null,
        public ?string $address = null,
        #[MapName('postal_code')]
        public ?string $postalCode = null,
        public ?string $city = null,
        #[MapName('country_code')]
        public ?string $countryCode = null,
        public ?string $email = null,
        public ?string $fax = null,
        public ?string $phone = null,
        #[MapName('language_code')]
        public ?string $languageCode = null,
        #[MapName('company_name')]
        public ?string $companyName = null,
        #[MapName('enterprise_number')]
        public ?string $enterpriseNumber = null,
    ) {}
}
