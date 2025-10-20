<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Data as SpatieData;

/**
 * Servicepack information.
 */
class Servicepack extends SpatieData
{
	public function __construct(
		public ?int $id = null,
		public ?string $name = null,
	) {
	}
}
