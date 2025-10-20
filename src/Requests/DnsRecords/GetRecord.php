<?php

namespace Joehoel\Combell\Requests\DnsRecords;

use Joehoel\Combell\Concerns\MapsToDto;
use Joehoel\Combell\Dto\DnsRecord;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetRecord
 */
class GetRecord extends Request
{
    use MapsToDto;

    protected Method $method = Method::GET;

    protected ?string $dtoClass = DnsRecord::class;

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
