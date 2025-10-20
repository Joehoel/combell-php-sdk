<?php

namespace Joehoel\Combell\Dto;

class Domain
{
    public function __construct(
        public ?string $domainName = null,
        public ?string $expirationDate = null,
        public ?bool $willRenew = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            domainName: $data['domain_name'] ?? null,
            expirationDate: $data['expiration_date'] ?? null,
            willRenew: $data['will_renew'] ?? null,
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }
}
