<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class ProvisioningJobCompletion extends SpatieData
{
	public function __construct(
		public ?string $id = null,
		#[MapName('resource_links')]
		public ?array $resourceLinks = null,
	) {
	}
}
