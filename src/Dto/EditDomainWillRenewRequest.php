<?php

namespace Joehoel\Combell\Dto;

class EditDomainWillRenewRequest
{
    public function __construct(
        public ?bool $willRenew = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            willRenew: $data['will_renew'] ?? null,
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }
}
