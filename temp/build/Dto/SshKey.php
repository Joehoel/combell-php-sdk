<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class SshKey extends SpatieData
{
	public function __construct(
		public ?string $fingerprint = null,
		#[MapName('public_key')]
		public ?string $publicKey = null,
	) {
	}
}
