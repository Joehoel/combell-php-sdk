<?php

namespace Joehoel\Combell\Requests\LinuxHostings;

use Joehoel\Combell\Dto\SshKey;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

/**
 * GetSshKeys
 */
class GetSshKeys extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/linuxhostings/{$this->domainName}/ssh/keys";
    }

    /**
     * @param  string  $domainName  Linux hosting domain name.
     */
    public function __construct(
        protected string $domainName,
    ) {}

    public function createDtoFromResponse(Response $response): array
    {
        return SshKey::collect($response->json());
    }
}
