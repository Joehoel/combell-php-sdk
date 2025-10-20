<?php

namespace Joehoel\Combell\Dto;

/**
 * The type of the certificate:
 * <ul><li>Standard: Certificate for a single domain.</li><li>Multi
 * domain: Certificate for multiple (sub)domains belonging to the same owner.</li><li>Wildcard:
 * Certificate for all the subdomains.</li></ul>
 */
class SslCertificateType
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
