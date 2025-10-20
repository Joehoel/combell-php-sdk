<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class UpdatePhpApcuRequest extends SpatieData
{
	public function __construct(
		#[MapName('apcu_size')]
		public ?int $apcuSize = null,
		public ?bool $enabled = null,
	) {
	}
}
