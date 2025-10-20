<?php

namespace Joehoel\Combell\Resource;

use Joehoel\Combell\Requests\Ssh\GetAllSshKeys;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

class Ssh extends BaseResource
{
	/**
	 * @param int $skip The number of items to skip in the resultset.
	 * @param int $take The number of items to return in the resultset. The returned count can be equal or less than this number.
	 */
	public function getAllSshKeys(?int $skip = null, ?int $take = null): Response
	{
		return $this->connector->send(new GetAllSshKeys($skip, $take));
	}
}
