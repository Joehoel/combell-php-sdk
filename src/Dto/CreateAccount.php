<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class CreateAccount extends SpatieData
{
	public function __construct(
		public ?string $identifier = null,
		#[MapName('servicepack_id')]
		public ?int $servicepackId = null,
		#[MapName('ftp_password')]
		public ?string $ftpPassword = null,
	) {
	}
}
