<?php

namespace Joehoel\Combell\Requests\SslCertificateRequests;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetSslCertificateRequests
 */
class GetSslCertificateRequests extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/sslcertificaterequests";
	}


	/**
	 * @param null|int $skip The number of items to skip in the resultset.
	 * @param null|int $take The number of items to return in the resultset. The returned count can be equal or less than this number.
	 */
	public function __construct(
		protected ?int $skip = null,
		protected ?int $take = null,
	) {
	}


	public function defaultQuery(): array
	{
		return array_filter(['skip' => $this->skip, 'take' => $this->take]);
	}
}
