<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class SshKeyDetail extends SpatieData
{
	public function __construct(
		public ?string $fingerprint = null,
		#[MapName('public_key')]
		public ?string $publicKey = null,
		#[MapName('linux_hostings')]
		public ?array $linuxHostings = null,
	) {
	}
}
