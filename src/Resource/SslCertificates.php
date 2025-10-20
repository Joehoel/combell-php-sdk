<?php

namespace Joehoel\Combell\Resource;

use Joehoel\Combell\Requests\SslCertificates\DownloadCertificate;
use Joehoel\Combell\Requests\SslCertificates\GetSslCertificate;
use Joehoel\Combell\Requests\SslCertificates\GetSslCertificates;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

class SslCertificates extends BaseResource
{
	/**
	 * @param int $skip The number of items to skip in the resultset.
	 * @param int $take The number of items to return in the resultset. The returned count can be equal or less than this number.
	 */
	public function getSslCertificates(?int $skip = null, ?int $take = null): Response
	{
		return $this->connector->send(new GetSslCertificates($skip, $take));
	}


	/**
	 * @param string $sha1Fingerprint The SHA-1 fingerprint of the certificate.
	 */
	public function getSslCertificate(string $sha1Fingerprint): Response
	{
		return $this->connector->send(new GetSslCertificate($sha1Fingerprint));
	}


	/**
	 * @param string $sha1Fingerprint The SHA-1 fingerprint of the certificate.
	 * @param string $fileFormat The file format of the returned file stream:
	 * <ul><li>PFX: Also known as PKCS #12, is a single, password protected certificate archive that contains the entire certificate chain plus the matching private key.</li></ul>
	 * @param string $password The password used to protect the certificate file.
	 */
	public function downloadCertificate(string $sha1Fingerprint, string $fileFormat, string $password): Response
	{
		return $this->connector->send(new DownloadCertificate($sha1Fingerprint, $fileFormat, $password));
	}
}
