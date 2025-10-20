<?php

namespace Joehoel\Combell\Requests\LinuxHostings;

use Joehoel\Combell\Concerns\MapsToDto;
use Joehoel\Combell\Dto\SshKey;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetSshKeys
 */
class GetSshKeys extends Request
{
    use MapsToDto;

    protected Method $method = Method::GET;

    protected ?string $dtoClass = SshKey::class;

    protected bool $dtoIsList = true;

    protected ?string $dtoCollectionKey = null;

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
}
