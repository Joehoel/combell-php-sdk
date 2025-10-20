<?php

namespace Joehoel\Combell\Requests\SslCertificates;

use Joehoel\Combell\Concerns\MapsToDto;
use Joehoel\Combell\Dto\SslCertificate;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetSslCertificates
 */
class GetSslCertificates extends Request
{
    use MapsToDto;

    protected Method $method = Method::GET;

    protected ?string $dtoClass = SslCertificate::class;

    protected bool $dtoIsList = true;

    protected ?string $dtoCollectionKey = 'items';

    public function resolveEndpoint(): string
    {
        return '/sslcertificates';
    }

    /**
     * @param  null|int  $skip  The number of items to skip in the resultset.
     * @param  null|int  $take  The number of items to return in the resultset. The returned count can be equal or less than this number.
     */
    public function __construct(
        protected ?int $skip = null,
        protected ?int $take = null,
    ) {}

    public function defaultQuery(): array
    {
        return array_filter(['skip' => $this->skip, 'take' => $this->take]);
    }
}
