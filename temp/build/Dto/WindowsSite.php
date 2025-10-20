<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Data as SpatieData;

class WindowsSite extends SpatieData
{
	public function __construct(
		public ?string $name = null,
		public ?string $path = null,
		public ?array $bindings = null,
	) {
	}
}
