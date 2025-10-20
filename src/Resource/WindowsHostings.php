<?php

namespace Joehoel\Combell\Resource;

use Joehoel\Combell\Requests\WindowsHostings\GetWindowsHosting;
use Joehoel\Combell\Requests\WindowsHostings\GetWindowsHostings;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

class WindowsHostings extends BaseResource
{
    /**
     * @param  int  $skip  The number of items to skip in the resultset.
     * @param  int  $take  The number of items to return in the resultset. The returned count can be equal or less than this number.
     */
    public function getWindowsHostings(?int $skip = null, ?int $take = null): Response
    {
        return $this->connector->send(new GetWindowsHostings($skip, $take));
    }

    /**
     * @param  string  $domainName  The Windows hosting domain name.
     */
    public function getWindowsHosting(string $domainName): Response
    {
        return $this->connector->send(new GetWindowsHosting($domainName));
    }
}
