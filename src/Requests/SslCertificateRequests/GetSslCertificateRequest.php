<?php

namespace Joehoel\Combell\Requests\SslCertificateRequests;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetSslCertificateRequest
 */
class GetSslCertificateRequest extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/sslcertificaterequests/{$this->id}";
	}


	/**
	 * @param int $id The id of the certificate request.
	 */
	public function __construct(
		protected int $id,
	) {
	}
}
