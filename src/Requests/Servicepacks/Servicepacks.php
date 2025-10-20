<?php

namespace Joehoel\Combell\Requests\Servicepacks;

use Joehoel\Combell\Dto\Servicepack;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

/**
 * Servicepacks
 */
class Servicepacks extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/servicepacks';
    }

    public function __construct() {}

    public function createDtoFromResponse(Response $response): array
    {
        return Servicepack::collect($response->json());
    }
}
