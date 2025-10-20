<?php

namespace Joehoel\Combell\Requests\MailZones;


use Joehoel\Combell\Dto\MailZone;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

/**
 * GetMailZone
 */
class GetMailZone extends Request
{

    protected Method $method = Method::GET;

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




    public function createDtoFromResponse(Response $response): MailZone
    {
        return MailZone::fromResponse($response->json());
    }

}
