<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class LinuxHostingDetail extends SpatieData
{
	public function __construct(
		#[MapName('domain_name')]
		public ?string $domainName = null,
		#[MapName('servicepack_id')]
		public ?int $servicepackId = null,
		#[MapName('max_webspace_size')]
		public ?int $maxWebspaceSize = null,
		#[MapName('max_size')]
		public ?int $maxSize = null,
		#[MapName('webspace_usage')]
		public ?int $webspaceUsage = null,
		#[MapName('actual_size')]
		public ?int $actualSize = null,
		public ?string $ip = null,
		#[MapName('ip_type')]
		public ?string $ipType = null,
		#[MapName('ftp_enabled')]
		public ?bool $ftpEnabled = null,
		#[MapName('ftp_username')]
		public ?string $ftpUsername = null,
		#[MapName('ssh_host')]
		public ?string $sshHost = null,
		#[MapName('ssh_username')]
		public ?string $sshUsername = null,
		#[MapName('php_version')]
		public ?string $phpVersion = null,
		public ?array $sites = null,
		#[MapName('mysql_database_names')]
		public ?array $mysqlDatabaseNames = null,
	) {
	}
}
