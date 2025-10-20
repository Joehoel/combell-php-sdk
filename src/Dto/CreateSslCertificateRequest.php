<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class CreateSslCertificateRequest extends SpatieData
{
    public function __construct(
        public ?string $csr = null,
        #[MapName('certificate_type')]
        public ?string $certificateType = null,
        #[MapName('validation_level')]
        public ?string $validationLevel = null,
        #[MapName('additional_validation_attributes')]
        public ?array $additionalValidationAttributes = null,
    ) {}
}
