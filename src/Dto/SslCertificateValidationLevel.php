<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Data as SpatieData;

/**
 * The validation level of the certificate:
 * <ul><li>Domain validated: Basic check of the identity of
 * the owner of the domain name.</li><li>Organization validated: Company details are verified and
 * integrated in the certificate.</li><li>Extended validated: A thorough verification of your domain
 * name and company details.</li></ul>
 */
class SslCertificateValidationLevel extends SpatieData
{
    public function __construct() {}
}
