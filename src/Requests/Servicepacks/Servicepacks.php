<?php

namespace Joehoel\Combell\Requests\Servicepacks;

use Joehoel\Combell\Concerns\MapsToDto;
use Joehoel\Combell\Dto\Servicepack;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Servicepacks
 */
class Servicepacks extends Request
{
    use MapsToDto;

    protected Method $method = Method::GET;

    protected ?string $dtoClass = Servicepack::class;

    protected bool $dtoIsList = true;

    protected ?string $dtoCollectionKey = null;

    public function resolveEndpoint(): string
    {
        return '/servicepacks';
    }

    public function __construct() {}
}
