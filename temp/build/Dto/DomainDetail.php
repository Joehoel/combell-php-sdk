<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class DomainDetail extends SpatieData
{
	public function __construct(
		#[MapName('domain_name')]
		public ?string $domainName = null,
		#[MapName('expiration_date')]
		public ?string $expirationDate = null,
		#[MapName('will_renew')]
		public ?bool $willRenew = null,
		#[MapName('name_servers')]
		public ?array $nameServers = null,
		public ?object $registrant = null,
		#[MapName('can_toggle_renew')]
		public ?bool $canToggleRenew = null,
	) {
	}
}
