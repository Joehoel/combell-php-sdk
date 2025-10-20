<?php

namespace Joehoel\Combell\Requests\DnsRecords;


use Joehoel\Combell\Dto\DnsRecord;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

/**
 * GetRecords
 */
class GetRecords extends Request
{

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/dns/{$this->domainName}/records";
    }

    /**
     * @param  string  $domainName  The domain name.
     * @param  null|int  $skip  The number of items to skip in the resultset.
     * @param  null|int  $take  The number of items to return in the resultset. The returned count can be equal or less than this number.
     * @param  null|string  $type  Filters records matching the type. Most other filters only apply when this filter is specified.
     * @param  null|string  $recordName  Filters records matching the record name. This filter only applies to lookups of A, AAAA, CAA, CNAME, MX, TXT, SRV, ALIAS and TLSA records.
     * @param  null|string  $service  Filters records for the service. This filter only applies to lookups of SRV records.
     */
    public function __construct(
        protected string $domainName,
        protected ?int $skip = null,
        protected ?int $take = null,
        protected ?string $type = null,
        protected ?string $recordName = null,
        protected ?string $service = null,
    ) {}

    public function defaultQuery(): array
    {
        return array_filter([
            'skip' => $this->skip,
            'take' => $this->take,
            'type' => $this->type,
            'record_name' => $this->recordName,
            'service' => $this->service,
        ]);
    }




    public function createDtoFromResponse(Response $response): array
    {
        return DnsRecord::collect($response->json('items'));
    }

}
