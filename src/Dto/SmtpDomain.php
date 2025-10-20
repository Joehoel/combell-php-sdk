<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Data as SpatieData;

class SmtpDomain extends SpatieData
{
	public function __construct(
		public ?string $hostname = null,
		public ?bool $enabled = null,
	) {
	}
}
