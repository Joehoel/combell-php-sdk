<?php

namespace Joehoel\Combell\Resource;

use Joehoel\Combell\Requests\SslCertificateRequests\AddSslCertificateRequest;
use Joehoel\Combell\Requests\SslCertificateRequests\GetSslCertificateRequest;
use Joehoel\Combell\Requests\SslCertificateRequests\GetSslCertificateRequests;
use Joehoel\Combell\Requests\SslCertificateRequests\VerifySslCertificateRequestDomainValidations;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

class SslCertificateRequests extends BaseResource
{
	/**
	 * @param int $skip The number of items to skip in the resultset.
	 * @param int $take The number of items to return in the resultset. The returned count can be equal or less than this number.
	 */
	public function getSslCertificateRequests(?int $skip = null, ?int $take = null): Response
	{
		return $this->connector->send(new GetSslCertificateRequests($skip, $take));
	}


	public function addSslCertificateRequest(): Response
	{
		return $this->connector->send(new AddSslCertificateRequest());
	}


	/**
	 * @param int $id The id of the certificate request.
	 */
	public function getSslCertificateRequest(int $id): Response
	{
		return $this->connector->send(new GetSslCertificateRequest($id));
	}


	/**
	 * @param int $id The id of the certificate request.
	 */
	public function verifySslCertificateRequestDomainValidations(int $id): Response
	{
		return $this->connector->send(new VerifySslCertificateRequestDomainValidations($id));
	}
}
