<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class EditNameServers extends SpatieData
{
	public function __construct(
		#[MapName('domain_name')]
		public ?string $domainName = null,
		#[MapName('name_servers')]
		public ?array $nameServers = null,
	) {
	}
}
