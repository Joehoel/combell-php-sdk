<?php

namespace Joehoel\Combell\Dto;

class WindowsHostingDetail
{
    public function __construct(
        public ?string $domainName = null,
        public ?int $servicepackId = null,
        public ?int $maxSize = null,
        public ?int $actualSize = null,
        public ?string $ip = null,
        public ?string $ipType = null,
        public ?string $ftpUsername = null,
        public ?object $applicationPool = null,
        public ?array $sites = null,
        public ?array $mssqlDatabaseNames = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            domainName: $data['domain_name'] ?? null,
            servicepackId: $data['servicepack_id'] ?? null,
            maxSize: $data['max_size'] ?? null,
            actualSize: $data['actual_size'] ?? null,
            ip: $data['ip'] ?? null,
            ipType: $data['ip_type'] ?? null,
            ftpUsername: $data['ftp_username'] ?? null,
            applicationPool: $data['application_pool'] ?? null,
            sites: $data['sites'] ?? [],
            mssqlDatabaseNames: $data['mssql_database_names'] ?? [],
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }
}
