<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class WindowsHostingDetail extends SpatieData
{
	public function __construct(
		#[MapName('domain_name')]
		public ?string $domainName = null,
		#[MapName('servicepack_id')]
		public ?int $servicepackId = null,
		#[MapName('max_size')]
		public ?int $maxSize = null,
		#[MapName('actual_size')]
		public ?int $actualSize = null,
		public ?string $ip = null,
		#[MapName('ip_type')]
		public ?string $ipType = null,
		#[MapName('ftp_username')]
		public ?string $ftpUsername = null,
		#[MapName('application_pool')]
		public ?object $applicationPool = null,
		public ?array $sites = null,
		#[MapName('mssql_database_names')]
		public ?array $mssqlDatabaseNames = null,
	) {
	}
}
