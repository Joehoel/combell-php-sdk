<?php

namespace Joehoel\Combell\Resource;

use Joehoel\Combell\Requests\Servicepacks\Servicepacks as ServicepacksRequest;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

class Servicepacks extends BaseResource
{
	public function servicepacks(): Response
	{
		return $this->connector->send(new ServicepacksRequest());
	}
}
