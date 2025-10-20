<?php

namespace Joehoel\Combell\Resource;

use Joehoel\Combell\Requests\MailZones\ConfigureAlias;
use Joehoel\Combell\Requests\MailZones\ConfigureAntiSpam;
use Joehoel\Combell\Requests\MailZones\ConfigureSmtpDomain;
use Joehoel\Combell\Requests\MailZones\CreateAlias;
use Joehoel\Combell\Requests\MailZones\CreateCatchAll;
use Joehoel\Combell\Requests\MailZones\CreateSmtpDomain;
use Joehoel\Combell\Requests\MailZones\DeleteAlias;
use Joehoel\Combell\Requests\MailZones\DeleteCatchAll;
use Joehoel\Combell\Requests\MailZones\DeleteSmtpDomain;
use Joehoel\Combell\Requests\MailZones\GetMailZone;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

class MailZones extends BaseResource
{
	/**
	 * @param string $domainName Mail zone domain name.
	 */
	public function getMailZone(string $domainName): Response
	{
		return $this->connector->send(new GetMailZone($domainName));
	}


	/**
	 * @param string $domainName Mail zone domain name.
	 */
	public function createCatchAll(string $domainName): Response
	{
		return $this->connector->send(new CreateCatchAll($domainName));
	}


	/**
	 * @param string $domainName Mail zone domain name.
	 * @param string $emailAddress E-mail address to which all e-mails are sent to inexistent mailboxes or aliases.
	 */
	public function deleteCatchAll(string $domainName, string $emailAddress): Response
	{
		return $this->connector->send(new DeleteCatchAll($domainName, $emailAddress));
	}


	/**
	 * @param string $domainName Mail zone domain name.
	 */
	public function configureAntiSpam(string $domainName): Response
	{
		return $this->connector->send(new ConfigureAntiSpam($domainName));
	}


	/**
	 * @param string $domainName Mail zone domain name.
	 */
	public function createAlias(string $domainName): Response
	{
		return $this->connector->send(new CreateAlias($domainName));
	}


	/**
	 * @param string $domainName Mail zone domain name.
	 * @param string $emailAddress Alias e-mail address.
	 */
	public function configureAlias(string $domainName, string $emailAddress): Response
	{
		return $this->connector->send(new ConfigureAlias($domainName, $emailAddress));
	}


	/**
	 * @param string $domainName Mail zone domain name.
	 * @param string $emailAddress Alias e-mail address.
	 */
	public function deleteAlias(string $domainName, string $emailAddress): Response
	{
		return $this->connector->send(new DeleteAlias($domainName, $emailAddress));
	}


	/**
	 * @param string $domainName Mail zone domain name.
	 */
	public function createSmtpDomain(string $domainName): Response
	{
		return $this->connector->send(new CreateSmtpDomain($domainName));
	}


	/**
	 * @param string $domainName Mail zone domain name.
	 * @param string $hostname Smtp domain name.
	 */
	public function configureSmtpDomain(string $domainName, string $hostname): Response
	{
		return $this->connector->send(new ConfigureSmtpDomain($domainName, $hostname));
	}


	/**
	 * @param string $domainName Mail zone domain name.
	 * @param string $hostname Smtp domain name.
	 */
	public function deleteSmtpDomain(string $domainName, string $hostname): Response
	{
		return $this->connector->send(new DeleteSmtpDomain($domainName, $hostname));
	}
}
