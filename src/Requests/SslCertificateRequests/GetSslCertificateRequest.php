<?php

namespace Joehoel\Combell\Requests\SslCertificateRequests;

use Joehoel\Combell\Dto\SslCertificateRequestDetail;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

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
     * @param  int  $id  The id of the certificate request.
     */
    public function __construct(
        protected int $id,
    ) {}

    public function createDtoFromResponse(Response $response): SslCertificateRequestDetail
    {
        return SslCertificateRequestDetail::fromResponse($response->json());
    }
}
