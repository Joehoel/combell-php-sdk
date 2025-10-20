<?php

namespace Joehoel\Combell\Resource;

use Joehoel\Combell\Requests\DnsRecords\CreateRecord;
use Joehoel\Combell\Requests\DnsRecords\DeleteRecord;
use Joehoel\Combell\Requests\DnsRecords\EditRecord;
use Joehoel\Combell\Requests\DnsRecords\GetRecord;
use Joehoel\Combell\Requests\DnsRecords\GetRecords;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

class DnsRecords extends BaseResource
{
	/**
	 * @param string $domainName The domain name.
	 * @param int $skip The number of items to skip in the resultset.
	 * @param int $take The number of items to return in the resultset. The returned count can be equal or less than this number.
	 * @param string $type Filters records matching the type. Most other filters only apply when this filter is specified.
	 * @param string $recordName Filters records matching the record name. This filter only applies to lookups of A, AAAA, CAA, CNAME, MX, TXT, SRV, ALIAS and TLSA records.
	 * @param string $service Filters records for the service. This filter only applies to lookups of SRV records.
	 */
	public function getRecords(
		string $domainName,
		?int $skip = null,
		?int $take = null,
		?string $type = null,
		?string $recordName = null,
		?string $service = null,
	): Response
	{
		return $this->connector->send(new GetRecords($domainName, $skip, $take, $type, $recordName, $service));
	}


	/**
	 * @param string $domainName The domain name.
	 */
	public function createRecord(string $domainName): Response
	{
		return $this->connector->send(new CreateRecord($domainName));
	}


	/**
	 * @param string $domainName The domain name.
	 * @param string $recordId The id of the record.
	 */
	public function getRecord(string $domainName, string $recordId): Response
	{
		return $this->connector->send(new GetRecord($domainName, $recordId));
	}


	/**
	 * @param string $domainName The domain name.
	 * @param string $recordId The id of the record.
	 */
	public function editRecord(string $domainName, string $recordId): Response
	{
		return $this->connector->send(new EditRecord($domainName, $recordId));
	}


	/**
	 * @param string $domainName The domain name.
	 * @param string $recordId The id of the record.
	 */
	public function deleteRecord(string $domainName, string $recordId): Response
	{
		return $this->connector->send(new DeleteRecord($domainName, $recordId));
	}
}
