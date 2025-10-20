<?php

namespace Joehoel\Combell\Dto;

/**
 * The domain validation verification type.
 */
class SslCertificateRequestValidationType
{
    public function __construct() {}

    public static function fromResponse(array $data): self
    {
        return new self;
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }
}
