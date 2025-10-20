<?php

namespace Joehoel\Combell\Requests\SslCertificates;


use Joehoel\Combell\Dto\SslCertificateDetail;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

/**
 * GetSslCertificate
 */
class GetSslCertificate extends Request
{

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/sslcertificates/{$this->sha1Fingerprint}";
    }

    /**
     * @param  string  $sha1Fingerprint  The SHA-1 fingerprint of the certificate.
     */
    public function __construct(protected string $sha1Fingerprint) {}




    public function createDtoFromResponse(Response $response): SslCertificateDetail
    {
        return SslCertificateDetail::fromResponse($response->json());
    }

}
