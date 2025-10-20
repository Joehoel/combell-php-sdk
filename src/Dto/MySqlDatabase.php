<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class MySqlDatabase extends SpatieData
{
	public function __construct(
		public ?string $name = null,
		public ?string $hostname = null,
		#[MapName('user_count')]
		public ?int $userCount = null,
		#[MapName('max_size')]
		public ?int $maxSize = null,
		#[MapName('actual_size')]
		public ?int $actualSize = null,
		#[MapName('account_id')]
		public ?int $accountId = null,
	) {
	}
}
