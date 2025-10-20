<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Data as SpatieData;

/**
 * A host header identifies a web domain.
 */
class HostHeader extends SpatieData
{
	public function __construct(
		public ?string $name = null,
		public ?bool $enabled = null,
	) {
	}
}
