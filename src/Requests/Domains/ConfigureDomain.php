<?php

namespace Joehoel\Combell\Requests\Domains;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * ConfigureDomain
 *
 * Allowed if can_toggle_renew is true on the domain detail:
 * <ul><li>If there are no unpaid invoices
 * for the domain name anymore.</li><li>If the renewal won't start within 1 month.</li></ul>
 * Allowed
 * if the requesting user has the finance role.
 */
class ConfigureDomain extends Request
{
    protected Method $method = Method::PUT;

    public function resolveEndpoint(): string
    {
        return "/domains/{$this->domainName}/renew";
    }

    /**
     * @param  string  $domainName  The domain name
     */
    public function __construct(
        protected string $domainName,
    ) {}
}
