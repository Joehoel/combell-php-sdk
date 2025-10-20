<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class EditDomainWillRenewRequest extends SpatieData
{
	public function __construct(
		#[MapName('will_renew')]
		public ?bool $willRenew = null,
	) {
	}
}
