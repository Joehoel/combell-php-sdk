<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class MailZoneAccount extends SpatieData
{
	public function __construct(
		#[MapName('account_id')]
		public ?int $accountId = null,
		public ?int $size = null,
	) {
	}
}
