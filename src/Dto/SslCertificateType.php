<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Data as SpatieData;

/**
 * The type of the certificate:
 * <ul><li>Standard: Certificate for a single domain.</li><li>Multi
 * domain: Certificate for multiple (sub)domains belonging to the same owner.</li><li>Wildcard:
 * Certificate for all the subdomains.</li></ul>
 */
class SslCertificateType extends SpatieData
{
    public function __construct() {}
}
