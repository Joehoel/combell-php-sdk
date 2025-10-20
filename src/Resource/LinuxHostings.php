<?php

namespace Joehoel\Combell\Resource;

use Joehoel\Combell\Requests\LinuxHostings\AddScheduledTasks;
use Joehoel\Combell\Requests\LinuxHostings\AddSshKey;
use Joehoel\Combell\Requests\LinuxHostings\ChangeApcu;
use Joehoel\Combell\Requests\LinuxHostings\ChangeAutoRedirect;
use Joehoel\Combell\Requests\LinuxHostings\ChangeGzipCompression;
use Joehoel\Combell\Requests\LinuxHostings\ChangeLetsEncrypt;
use Joehoel\Combell\Requests\LinuxHostings\ChangePhpMemoryLimit;
use Joehoel\Combell\Requests\LinuxHostings\ChangePhpVersion;
use Joehoel\Combell\Requests\LinuxHostings\ConfigureFtp;
use Joehoel\Combell\Requests\LinuxHostings\ConfigureHttp2;
use Joehoel\Combell\Requests\LinuxHostings\ConfigureScheduledTask;
use Joehoel\Combell\Requests\LinuxHostings\ConfigureSsh;
use Joehoel\Combell\Requests\LinuxHostings\CreateHostHeader;
use Joehoel\Combell\Requests\LinuxHostings\CreateSubsite;
use Joehoel\Combell\Requests\LinuxHostings\DeleteScheduledTask;
use Joehoel\Combell\Requests\LinuxHostings\DeleteSshKey;
use Joehoel\Combell\Requests\LinuxHostings\DeleteSubsite;
use Joehoel\Combell\Requests\LinuxHostings\GetAvailablePhpVersions;
use Joehoel\Combell\Requests\LinuxHostings\GetLinuxHosting;
use Joehoel\Combell\Requests\LinuxHostings\GetLinuxHostings;
use Joehoel\Combell\Requests\LinuxHostings\GetScheduledTask;
use Joehoel\Combell\Requests\LinuxHostings\GetScheduledTasks;
use Joehoel\Combell\Requests\LinuxHostings\GetSshKeys;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

class LinuxHostings extends BaseResource
{
    /**
     * @param  int  $skip  The number of items to skip in the resultset.
     * @param  int  $take  The number of items to return in the resultset. The returned count can be equal or less than this number.
     */
    public function getLinuxHostings(?int $skip = null, ?int $take = null): Response
    {
        return $this->connector->send(new GetLinuxHostings($skip, $take));
    }

    /**
     * @param  string  $domainName  The Linux hosting domain name.
     */
    public function getLinuxHosting(string $domainName): Response
    {
        return $this->connector->send(new GetLinuxHosting($domainName));
    }

    /**
     * @param  string  $domainName  Linux hosting domain name.
     */
    public function getAvailablePhpVersions(string $domainName): Response
    {
        return $this->connector->send(new GetAvailablePhpVersions($domainName));
    }

    /**
     * @param  string  $domainName  Linux hosting domain name.
     */
    public function changePhpVersion(string $domainName): Response
    {
        return $this->connector->send(new ChangePhpVersion($domainName));
    }

    /**
     * @param  string  $domainName  Linux hosting domain name
     */
    public function changeGzipCompression(string $domainName): Response
    {
        return $this->connector->send(new ChangeGzipCompression($domainName));
    }

    /**
     * @param  string  $domainName  Linux hosting domain name.
     */
    public function createSubsite(string $domainName): Response
    {
        return $this->connector->send(new CreateSubsite($domainName));
    }

    /**
     * @param  string  $domainName  Linux hosting domain name.
     * @param  string  $siteName  Name of the site on the linux hosting.
     */
    public function deleteSubsite(string $domainName, string $siteName): Response
    {
        return $this->connector->send(new DeleteSubsite($domainName, $siteName));
    }

    /**
     * @param  string  $domainName  Linux hosting domain name.
     * @param  string  $siteName  Name of the site on the linux hosting.
     */
    public function createHostHeader(string $domainName, string $siteName): Response
    {
        return $this->connector->send(new CreateHostHeader($domainName, $siteName));
    }

    /**
     * @param  string  $domainName  Linux hosting domain name.
     * @param  string  $siteName  Site name where HTTP/2 should be configured.
     *
     * For HTTP/2 to work correctly, the site must have ssl enabled.
     */
    public function configureHttp2(string $domainName, string $siteName): Response
    {
        return $this->connector->send(new ConfigureHttp2($domainName, $siteName));
    }

    /**
     * @param  string  $domainName  Linux hosting domain name.
     */
    public function configureFtp(string $domainName): Response
    {
        return $this->connector->send(new ConfigureFtp($domainName));
    }

    /**
     * @param  string  $domainName  Linux hosting domain name.
     * @param  string  $hostname  Specific hostname.
     */
    public function changeLetsEncrypt(string $domainName, string $hostname): Response
    {
        return $this->connector->send(new ChangeLetsEncrypt($domainName, $hostname));
    }

    /**
     * @param  string  $domainName  Linux hosting domain name.
     * @param  string  $hostname  Specific hostname.
     */
    public function changeAutoRedirect(string $domainName, string $hostname): Response
    {
        return $this->connector->send(new ChangeAutoRedirect($domainName, $hostname));
    }

    /**
     * @param  string  $domainName  Linux hosting domain name.
     */
    public function changePhpMemoryLimit(string $domainName): Response
    {
        return $this->connector->send(new ChangePhpMemoryLimit($domainName));
    }

    /**
     * @param  string  $domainName  Linux hosting domain name
     */
    public function changeApcu(string $domainName): Response
    {
        return $this->connector->send(new ChangeApcu($domainName));
    }

    /**
     * @param  string  $domainName  Linux hosting domain name.
     */
    public function getScheduledTasks(string $domainName): Response
    {
        return $this->connector->send(new GetScheduledTasks($domainName));
    }

    /**
     * @param  string  $domainName  Linux hosting domain name.
     */
    public function addScheduledTasks(string $domainName): Response
    {
        return $this->connector->send(new AddScheduledTasks($domainName));
    }

    /**
     * @param  string  $domainName  Linux hosting domain name.
     * @param  string  $scheduledTaskId  Id of the scheduled task.
     */
    public function getScheduledTask(string $domainName, string $scheduledTaskId): Response
    {
        return $this->connector->send(new GetScheduledTask($domainName, $scheduledTaskId));
    }

    /**
     * @param  string  $domainName  Linux hosting domain name.
     * @param  string  $scheduledTaskId  Id of the scheduled task.
     */
    public function configureScheduledTask(string $domainName, string $scheduledTaskId): Response
    {
        return $this->connector->send(new ConfigureScheduledTask($domainName, $scheduledTaskId));
    }

    /**
     * @param  string  $domainName  Linux hosting domain name.
     * @param  string  $scheduledTaskId  Id of the scheduled task.
     */
    public function deleteScheduledTask(string $domainName, string $scheduledTaskId): Response
    {
        return $this->connector->send(new DeleteScheduledTask($domainName, $scheduledTaskId));
    }

    /**
     * @param  string  $domainName  Linux hosting domain name.
     */
    public function getSshKeys(string $domainName): Response
    {
        return $this->connector->send(new GetSshKeys($domainName));
    }

    /**
     * @param  string  $domainName  Linux hosting domain name.
     */
    public function addSshKey(string $domainName): Response
    {
        return $this->connector->send(new AddSshKey($domainName));
    }

    /**
     * @param  string  $domainName  Linux hosting domain name.
     */
    public function configureSsh(string $domainName): Response
    {
        return $this->connector->send(new ConfigureSsh($domainName));
    }

    /**
     * @param  string  $domainName  Linux hosting domain name.
     * @param  string  $fingerprint  Fingerprint of public key.
     */
    public function deleteSshKey(string $domainName, string $fingerprint): Response
    {
        return $this->connector->send(new DeleteSshKey($domainName, $fingerprint));
    }
}
