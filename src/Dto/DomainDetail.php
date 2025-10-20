<?php

namespace Joehoel\Combell\Dto;


class DomainDetail
{
    public function __construct(
public ?string $domainName = null,
public ?string $expirationDate = null,
public ?bool $willRenew = null,
public ?array $nameServers = null,
        public ?object $registrant = null,
public ?bool $canToggleRenew = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            domainName: $data['domain_name'] ?? null,
            expirationDate: $data['expiration_date'] ?? null,
            willRenew: $data['will_renew'] ?? null,
            nameServers: $data['name_servers'] ?? [],
            registrant: $data['registrant'] ?? null,
            canToggleRenew: $data['can_toggle_renew'] ?? null,
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }

}
