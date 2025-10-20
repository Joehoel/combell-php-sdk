<?php

namespace Joehoel\Combell\Requests\MailZones;

use Joehoel\Combell\Concerns\MapsToDto;
use Joehoel\Combell\Dto\MailZone;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetMailZone
 */
class GetMailZone extends Request
{
    use MapsToDto;

    protected Method $method = Method::GET;

    protected ?string $dtoClass = MailZone::class;

    public function resolveEndpoint(): string
    {
        return "/mailzones/{$this->domainName}";
    }

    /**
     * @param  string  $domainName  Mail zone domain name.
     */
    public function __construct(
        protected string $domainName,
    ) {}
}
