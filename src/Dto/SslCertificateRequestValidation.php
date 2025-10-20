<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class SslCertificateRequestValidation extends SpatieData
{
	public function __construct(
		#[MapName('dns_name')]
		public ?string $dnsName = null,
		public ?string $type = null,
		#[MapName('auto_validated')]
		public ?bool $autoValidated = null,
		#[MapName('email_addresses')]
		public ?array $emailAddresses = null,
		#[MapName('cname_validation_name')]
		public ?string $cnameValidationName = null,
		#[MapName('cname_validation_content')]
		public ?string $cnameValidationContent = null,
		#[MapName('file_validation_url_http')]
		public ?string $fileValidationUrlHttp = null,
		#[MapName('file_validation_url_https')]
		public ?string $fileValidationUrlHttps = null,
		#[MapName('file_validation_content')]
		public ?array $fileValidationContent = null,
	) {
	}
}
