<?php

namespace Joehoel\Combell\Requests\DnsRecords;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * CreateRecord
 */
class CreateRecord extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return "/dns/{$this->domainName}/records";
    }

    /**
     * @param  string  $domainName  The domain name.
     */
    public function __construct(
        protected string $domainName,
    ) {}
}
