<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Data as SpatieData;

class UpdateAntiSpamRequest extends SpatieData
{
	public function __construct(
		public ?string $type = null,
	) {
	}
}
