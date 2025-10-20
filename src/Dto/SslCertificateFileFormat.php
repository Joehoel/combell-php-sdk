<?php

namespace Joehoel\Combell\Dto;

/**
 * The file format of the returned file stream:
 * <ul><li>PFX: Also known as PKCS #12, is a single,
 * password protected certificate archive that contains the entire certificate chain plus the matching
 * private key.</li></ul>
 */
class SslCertificateFileFormat
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
