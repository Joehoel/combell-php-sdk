<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Data as SpatieData;

class UpdateUserStatusRequest extends SpatieData
{
	public function __construct(
		public ?bool $enabled = null,
	) {
	}
}
