<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class CatchAll extends SpatieData
{
	public function __construct(
		#[MapName('email_addresses')]
		public ?array $emailAddresses = null,
	) {
	}
}
