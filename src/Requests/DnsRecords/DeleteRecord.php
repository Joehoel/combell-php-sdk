<?php

namespace Joehoel\Combell\Requests\DnsRecords;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * DeleteRecord
 */
class DeleteRecord extends Request
{
    protected Method $method = Method::DELETE;

    public function resolveEndpoint(): string
    {
        return "/dns/{$this->domainName}/records/{$this->recordId}";
    }

    /**
     * @param  string  $domainName  The domain name.
     * @param  string  $recordId  The id of the record.
     */
    public function __construct(
        protected string $domainName,
        protected string $recordId,
    ) {}
}
