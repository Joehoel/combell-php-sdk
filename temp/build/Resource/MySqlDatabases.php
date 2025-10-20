<?php

namespace Joehoel\Combell\Resource;

use Joehoel\Combell\Requests\MySqlDatabases\ChangeDatabaseUserPassword;
use Joehoel\Combell\Requests\MySqlDatabases\ChangeDatabaseUserStatus;
use Joehoel\Combell\Requests\MySqlDatabases\CreateMySqlDatabase;
use Joehoel\Combell\Requests\MySqlDatabases\CreateMySqlUser;
use Joehoel\Combell\Requests\MySqlDatabases\DeleteDatabase;
use Joehoel\Combell\Requests\MySqlDatabases\DeleteDatabaseUser;
use Joehoel\Combell\Requests\MySqlDatabases\GetDatabaseUsers;
use Joehoel\Combell\Requests\MySqlDatabases\GetMySqlDatabase;
use Joehoel\Combell\Requests\MySqlDatabases\GetMySqlDatabases;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

class MySqlDatabases extends BaseResource
{
	/**
	 * @param int $skip The number of items to skip in the resultset.
	 * @param int $take The number of items to return in the resultset. The returned count can be equal or less than this number.
	 */
	public function getMySqlDatabases(?int $skip = null, ?int $take = null): Response
	{
		return $this->connector->send(new GetMySqlDatabases($skip, $take));
	}


	public function createMySqlDatabase(): Response
	{
		return $this->connector->send(new CreateMySqlDatabase());
	}


	/**
	 * @param string $databaseName
	 */
	public function getMySqlDatabase(string $databaseName): Response
	{
		return $this->connector->send(new GetMySqlDatabase($databaseName));
	}


	/**
	 * @param string $databaseName Name of the database.
	 */
	public function deleteDatabase(string $databaseName): Response
	{
		return $this->connector->send(new DeleteDatabase($databaseName));
	}


	/**
	 * @param string $databaseName Name of the database.
	 */
	public function getDatabaseUsers(string $databaseName): Response
	{
		return $this->connector->send(new GetDatabaseUsers($databaseName));
	}


	/**
	 * @param string $databaseName Name of the database.
	 */
	public function createMySqlUser(string $databaseName): Response
	{
		return $this->connector->send(new CreateMySqlUser($databaseName));
	}


	/**
	 * @param string $databaseName Name of the database.
	 * @param string $userName Name of the user.
	 */
	public function changeDatabaseUserStatus(string $databaseName, string $userName): Response
	{
		return $this->connector->send(new ChangeDatabaseUserStatus($databaseName, $userName));
	}


	/**
	 * @param string $databaseName Name of the database.
	 * @param string $userName Name of the user.
	 */
	public function changeDatabaseUserPassword(string $databaseName, string $userName): Response
	{
		return $this->connector->send(new ChangeDatabaseUserPassword($databaseName, $userName));
	}


	/**
	 * @param string $databaseName Name of the database.
	 * @param string $userName Name of the user.
	 */
	public function deleteDatabaseUser(string $databaseName, string $userName): Response
	{
		return $this->connector->send(new DeleteDatabaseUser($databaseName, $userName));
	}
}
