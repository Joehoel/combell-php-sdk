<?php

namespace Joehoel\Combell\Requests\Accounts;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * CreateAccount
 *
 * The creation of an account requires some background processing. There is no instant feedback of the
 * creation status.
 */
class CreateAccount extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/accounts';
    }

    public function __construct() {}
}
