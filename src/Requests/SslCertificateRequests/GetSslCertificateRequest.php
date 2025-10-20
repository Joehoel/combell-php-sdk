<?php

namespace Joehoel\Combell\Requests\SslCertificateRequests;

use Joehoel\Combell\Concerns\MapsToDto;
use Joehoel\Combell\Dto\SslCertificateRequestDetail;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetSslCertificateRequest
 */
class GetSslCertificateRequest extends Request
{
    use MapsToDto;

    protected Method $method = Method::GET;

    protected ?string $dtoClass = SslCertificateRequestDetail::class;

    public function resolveEndpoint(): string
    {
        return "/sslcertificaterequests/{$this->id}";
    }

    /**
     * @param  int  $id  The id of the certificate request.
     */
    public function __construct(
        protected int $id,
    ) {}
}
