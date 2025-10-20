<?php

namespace Joehoel\Combell\Dto;


/**
 * The validation level of the certificate:
 * <ul><li>Domain validated: Basic check of the identity of
 * the owner of the domain name.</li><li>Organization validated: Company details are verified and
 * integrated in the certificate.</li><li>Extended validated: A thorough verification of your domain
 * name and company details.</li></ul>
 */
class SslCertificateValidationLevel
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
