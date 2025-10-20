<?php

namespace Joehoel\Combell\Resource;

use Joehoel\Combell\Requests\Domains\ConfigureDomain;
use Joehoel\Combell\Requests\Domains\EditNameServers;
use Joehoel\Combell\Requests\Domains\GetDomain;
use Joehoel\Combell\Requests\Domains\GetDomains;
use Joehoel\Combell\Requests\Domains\Register;
use Joehoel\Combell\Requests\Domains\Transfer;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

class Domains extends BaseResource
{
    /**
     * @param  int  $skip  The number of items to skip in the resultset.
     * @param  int  $take  The number of items to return in the resultset. The returned count can be equal or less than this number.
     */
    public function getDomains(?int $skip = null, ?int $take = null): Response
    {
        return $this->connector->send(new GetDomains($skip, $take));
    }

    /**
     * @param  string  $domainName  The domain name
     */
    public function getDomain(string $domainName): Response
    {
        return $this->connector->send(new GetDomain($domainName));
    }

    public function register(): Response
    {
        return $this->connector->send(new Register());
    }

    public function transfer(): Response
    {
        return $this->connector->send(new Transfer());
    }

    /**
     * @param  string  $domainName  The domain name
     */
    public function editNameServers(string $domainName): Response
    {
        return $this->connector->send(new EditNameServers($domainName));
    }

    /**
     * @param  string  $domainName  The domain name
     */
    public function configureDomain(string $domainName): Response
    {
        return $this->connector->send(new ConfigureDomain($domainName));
    }
}
