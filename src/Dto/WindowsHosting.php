<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class WindowsHosting extends SpatieData
{
	public function __construct(
		#[MapName('domain_name')]
		public ?string $domainName = null,
		#[MapName('servicepack_id')]
		public ?int $servicepackId = null,
	) {
	}
}
