<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class LinuxSite extends SpatieData
{
	public function __construct(
		public ?string $name = null,
		public ?string $path = null,
		#[MapName('host_headers')]
		public ?array $hostHeaders = null,
		#[MapName('ssl_enabled')]
		public ?bool $sslEnabled = null,
		#[MapName('https_redirect_enabled')]
		public ?bool $httpsRedirectEnabled = null,
		#[MapName('http2_enabled')]
		public ?bool $http2Enabled = null,
	) {
	}
}
