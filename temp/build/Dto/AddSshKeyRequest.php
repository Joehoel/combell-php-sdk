<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class AddSshKeyRequest extends SpatieData
{
	public function __construct(
		#[MapName('public_key')]
		public ?string $publicKey = null,
	) {
	}
}
