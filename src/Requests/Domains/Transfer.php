<?php

namespace Joehoel\Combell\Requests\Domains;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Transfer
 *
 * Transfers a domain with a transfer authorization code.
 * Domain names with extension '.ca' are only
 * available for registrants with country code 'CA'.
 */
class Transfer extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/domains/transfers';
    }

    public function __construct() {}
}
