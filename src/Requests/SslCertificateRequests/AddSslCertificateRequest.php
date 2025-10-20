<?php

namespace Joehoel\Combell\Requests\SslCertificateRequests;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * AddSslCertificateRequest
 *
 * Executing this method causes the purchase of a paying product.
 *
 * Log on to our website to see your
 * current (renewal) prices or contact our Sales department.
 *
 * Please note that promotional pricing
 * does not apply for purchases made through our API.
 */
class AddSslCertificateRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/sslcertificaterequests';
    }

    public function __construct() {}
}
