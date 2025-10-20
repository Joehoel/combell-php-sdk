<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class SslCertificateRequestDetail extends SpatieData
{
	public function __construct(
		public ?int $id = null,
		#[MapName('certificate_type')]
		public ?string $certificateType = null,
		#[MapName('validation_level')]
		public ?string $validationLevel = null,
		public ?string $vendor = null,
		#[MapName('common_name')]
		public ?string $commonName = null,
		#[MapName('order_code')]
		public ?string $orderCode = null,
		#[MapName('subject_alt_names')]
		public ?array $subjectAltNames = null,
		public ?array $validations = null,
		#[MapName('provider_portal_url')]
		public ?string $providerPortalUrl = null,
	) {
	}
}
