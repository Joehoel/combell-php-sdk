<?php

namespace Joehoel\Combell\Requests\Servicepacks;

use Saloon\Enums\Method;
use Saloon\Http\Request;

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
}
