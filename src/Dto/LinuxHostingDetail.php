<?php

namespace Joehoel\Combell\Dto;


class LinuxHostingDetail
{
    public function __construct(
public ?string $domainName = null,
public ?int $servicepackId = null,
public ?int $maxWebspaceSize = null,
public ?int $maxSize = null,
public ?int $webspaceUsage = null,
public ?int $actualSize = null,
        public ?string $ip = null,
public ?string $ipType = null,
public ?bool $ftpEnabled = null,
public ?string $ftpUsername = null,
public ?string $sshHost = null,
public ?string $sshUsername = null,
public ?string $phpVersion = null,
        public ?array $sites = null,
public ?array $mysqlDatabaseNames = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            domainName: $data['domain_name'] ?? null,
            servicepackId: $data['servicepack_id'] ?? null,
            maxWebspaceSize: $data['max_webspace_size'] ?? null,
            maxSize: $data['max_size'] ?? null,
            webspaceUsage: $data['webspace_usage'] ?? null,
            actualSize: $data['actual_size'] ?? null,
            ip: $data['ip'] ?? null,
            ipType: $data['ip_type'] ?? null,
            ftpEnabled: $data['ftp_enabled'] ?? null,
            ftpUsername: $data['ftp_username'] ?? null,
            sshHost: $data['ssh_host'] ?? null,
            sshUsername: $data['ssh_username'] ?? null,
            phpVersion: $data['php_version'] ?? null,
            sites: $data['sites'] ?? [],
            mysqlDatabaseNames: $data['mysql_database_names'] ?? [],
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }

}
