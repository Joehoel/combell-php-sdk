<?php

namespace Joehoel\Combell\Requests\WindowsHostings;

use Joehoel\Combell\Dto\WindowsHosting;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

/**
 * GetWindowsHostings
 */
class GetWindowsHostings extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/windowshostings';
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

    public function createDtoFromResponse(Response $response): array
    {
        return WindowsHosting::collect($response->json('items'));
    }
}
