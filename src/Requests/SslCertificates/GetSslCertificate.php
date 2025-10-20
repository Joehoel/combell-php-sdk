<?php

namespace Joehoel\Combell\Requests\SslCertificates;

use Joehoel\Combell\Concerns\MapsToDto;
use Joehoel\Combell\Dto\SslCertificateDetail;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetSslCertificate
 */
class GetSslCertificate extends Request
{
    use MapsToDto;

    protected Method $method = Method::GET;

    protected ?string $dtoClass = SslCertificateDetail::class;

    public function resolveEndpoint(): string
    {
        return "/sslcertificates/{$this->sha1Fingerprint}";
    }

    /**
     * @param  string  $sha1Fingerprint  The SHA-1 fingerprint of the certificate.
     */
    public function __construct(protected string $sha1Fingerprint) {}
}
