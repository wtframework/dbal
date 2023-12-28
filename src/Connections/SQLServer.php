<?php

declare(strict_types=1);

namespace WTFramework\DBAL\Connections;

use BadMethodCallException;
use WTFramework\DBAL\Connection;
use WTFramework\DBAL\Grammars\SQLServer\Alter;
use WTFramework\DBAL\Grammars\SQLServer\Create;
use WTFramework\DBAL\Grammars\SQLServer\CreateIndex;
use WTFramework\DBAL\Grammars\SQLServer\Delete;
use WTFramework\DBAL\Grammars\SQLServer\Drop;
use WTFramework\DBAL\Grammars\SQLServer\DropIndex;
use WTFramework\DBAL\Grammars\SQLServer\Insert;
use WTFramework\DBAL\Grammars\SQLServer\Select;
use WTFramework\DBAL\Grammars\SQLServer\Truncate;
use WTFramework\DBAL\Grammars\SQLServer\Update;
use WTFramework\SQL\Grammars\SQLServer\Helpers\Column;
use WTFramework\SQL\Grammars\SQLServer\Helpers\Constraint;
use WTFramework\SQL\Grammars\SQLServer\Helpers\CTE;
use WTFramework\SQL\Grammars\SQLServer\Helpers\Subquery;
use WTFramework\SQL\Grammars\SQLServer\Helpers\Table;
use WTFramework\SQL\Interfaces\HasBindings;

class SQLServer extends Connection
{

  public static function dsn(#[\SensitiveParameter] array $config): string
  {

    foreach ([
      'Server',
      'Database',
      'APP',
      'ConnectionPooling',
      'Encrypt',
      'Failover_Partner',
      'LoginTimeout',
      'MultipleActiveResultSets',
      'QuotedId',
      'TraceFile',
      'TraceOn',
      'TransactionIsolation',
      'TrustServerCertificate',
      'WSID',
    ] as $key)
    {

      $config[$key] ??= '';

      $$key = $config[$key] ? "$key={$config[$key]}" : '';

    }

    $dsn = implode(';', array_filter([
      $Server,
      $Database,
      $APP,
      $ConnectionPooling,
      $Encrypt,
      $Failover_Partner,
      $LoginTimeout,
      $MultipleActiveResultSets,
      $QuotedId,
      $TraceFile,
      $TraceOn,
      $TransactionIsolation,
      $TrustServerCertificate,
      $WSID,
    ]));

    return "sqlsrv:$dsn";

  }

  public function alter(string|HasBindings|array $table = null): Alter
  {
    return new Alter(connection: $this, table: $table);
  }

  public function create(string|HasBindings|array $table = null): Create
  {
    return new Create(connection: $this, table: $table);
  }

  public function createIndex(string $index): CreateIndex
  {
    return new CreateIndex(connection: $this, index: $index);
  }

  public function delete(string|HasBindings|array $table = null): Delete
  {
    return new Delete(connection: $this, table: $table);
  }

  public function drop(string|HasBindings|array $table = null): Drop
  {
    return new Drop(connection: $this, table: $table);
  }

  public function dropIndex(string $index): DropIndex
  {
    return new DropIndex(connection: $this, index: $index);
  }

  public function insert(string|HasBindings|array $table = null): Insert
  {
    return new Insert(connection: $this, table: $table);
  }

  public function replace(string|HasBindings|array $table = null): never
  {
    throw new BadMethodCallException("SQLServer does not support REPLACE statements.");
  }

  public function select(string|HasBindings|array $table = null): Select
  {
    return new Select(connection: $this, table: $table);
  }

  public function truncate(string|HasBindings $table = null): Truncate
  {
    return new Truncate(connection: $this, table: $table);
  }

  public function update(string|HasBindings|array $table = null): Update
  {
    return new Update(connection: $this, table: $table);
  }

  public static function column(string $name): Column
  {
    return new Column(name: $name);
  }

  public static function constraint(string $name): Constraint
  {
    return new Constraint(name: $name);
  }

  public static function cte(
    string $name,
    string|HasBindings $stmt
  ): CTE
  {

    return new CTE(
      name: $name,
      stmt: $stmt
    );

  }

  public static function index(string $name): never
  {
    throw new BadMethodCallException("SQLServer does not support indexes.");
  }

  public static function partition(string $name): never
  {
    throw new BadMethodCallException("SQLServer does not support partitions.");
  }

  public static function subpartition(string $name): never
  {
    throw new BadMethodCallException("SQLServer does not support subpartitions.");
  }

  public static function subquery(string|HasBindings $stmt): Subquery
  {
    return new Subquery(stmt: $stmt);
  }

  public static function table(string $name): Table
  {
    return new Table(name: $name);
  }

  public static function upsert(): never
  {
    throw new BadMethodCallException("SQLServer does not support upserts.");
  }

}