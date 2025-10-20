<?php

namespace Joehoel\Combell\Dto;


/**
 * The vendor of the certificate.
 */
class SslCertificateVendor
{
    public function __construct() {}

    public static function fromResponse(array $data): self
    {
        return new self(

        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }

}
