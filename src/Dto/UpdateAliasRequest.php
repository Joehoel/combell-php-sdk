<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Data as SpatieData;

class UpdateAliasRequest extends SpatieData
{
	public function __construct(
		public ?array $destinations = null,
	) {
	}
}
