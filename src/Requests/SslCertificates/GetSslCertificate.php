<?php

namespace Joehoel\Combell\Requests\SslCertificates;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetSslCertificate
 */
class GetSslCertificate extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/sslcertificates/{$this->sha1fingerprint}";
	}


	/**
	 * @param string $sha1Fingerprint The SHA-1 fingerprint of the certificate.
	 */
	public function __construct(
		protected string $sha1Fingerprint,
	) {
	}
}
