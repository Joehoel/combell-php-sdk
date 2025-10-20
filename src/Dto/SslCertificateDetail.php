<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class SslCertificateDetail extends SpatieData
{
    public function __construct(
        #[MapName('sha1_fingerprint')]
        public ?string $sha1Fingerprint = null,
        #[MapName('common_name')]
        public ?string $commonName = null,
        #[MapName('expires_after')]
        public ?string $expiresAfter = null,
        #[MapName('validation_level')]
        public ?string $validationLevel = null,
        public ?string $type = null,
        #[MapName('subject_alt_names')]
        public ?array $subjectAltNames = null,
    ) {}
}
