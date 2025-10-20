<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Data as SpatieData;

class ExtraField extends SpatieData
{
	public function __construct(
		public ?string $name = null,
		public ?string $value = null,
	) {
	}
}
