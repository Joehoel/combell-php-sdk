<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class Domain extends SpatieData
{
	public function __construct(
		#[MapName('domain_name')]
		public ?string $domainName = null,
		#[MapName('expiration_date')]
		public ?string $expirationDate = null,
		#[MapName('will_renew')]
		public ?bool $willRenew = null,
	) {
	}
}
