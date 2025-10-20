<?php

namespace Joehoel\Combell\Requests\DnsRecords;

use Joehoel\Combell\Dto\DnsRecord;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

/**
 * GetRecord
 */
class GetRecord extends Request
{
    protected Method $method = Method::GET;

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

    public function createDtoFromResponse(Response $response): DnsRecord
    {
        return DnsRecord::fromResponse($response->json());
    }
}
