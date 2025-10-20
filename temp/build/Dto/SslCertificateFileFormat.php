<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Data as SpatieData;

/**
 * The file format of the returned file stream:
 * <ul><li>PFX: Also known as PKCS #12, is a single,
 * password protected certificate archive that contains the entire certificate chain plus the matching
 * private key.</li></ul>
 */
class SslCertificateFileFormat extends SpatieData
{
	public function __construct()
	{
	}
}
