<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class MailZone extends SpatieData
{
	public function __construct(
		public ?string $name = null,
		public ?bool $enabled = null,
		#[MapName('available_accounts')]
		public ?array $availableAccounts = null,
		public ?array $aliases = null,
		#[MapName('anti_spam')]
		public ?object $antiSpam = null,
		#[MapName('catch_all')]
		public ?object $catchAll = null,
		#[MapName('smtp_domains')]
		public ?array $smtpDomains = null,
	) {
	}
}
