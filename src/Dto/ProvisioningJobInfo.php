<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Data as SpatieData;

class ProvisioningJobInfo extends SpatieData
{
	public function __construct(
		public ?string $id = null,
		public ?string $status = null,
		public ?object $completion = null,
	) {
	}
}
