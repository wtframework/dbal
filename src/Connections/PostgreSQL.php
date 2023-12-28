<?php

declare(strict_types=1);

namespace WTFramework\DBAL\Connections;

use BadMethodCallException;
use WTFramework\DBAL\Connection;
use WTFramework\DBAL\Grammars\PostgreSQL\Alter;
use WTFramework\DBAL\Grammars\PostgreSQL\Create;
use WTFramework\DBAL\Grammars\PostgreSQL\CreateIndex;
use WTFramework\DBAL\Grammars\PostgreSQL\Delete;
use WTFramework\DBAL\Grammars\PostgreSQL\Drop;
use WTFramework\DBAL\Grammars\PostgreSQL\DropIndex;
use WTFramework\DBAL\Grammars\PostgreSQL\Insert;
use WTFramework\DBAL\Grammars\PostgreSQL\Select;
use WTFramework\DBAL\Grammars\PostgreSQL\Truncate;
use WTFramework\DBAL\Grammars\PostgreSQL\Update;
use WTFramework\SQL\Grammars\PostgreSQL\Helpers\Column;
use WTFramework\SQL\Grammars\PostgreSQL\Helpers\Constraint;
use WTFramework\SQL\Grammars\PostgreSQL\Helpers\CTE;
use WTFramework\SQL\Grammars\PostgreSQL\Helpers\Subquery;
use WTFramework\SQL\Grammars\PostgreSQL\Helpers\Table;
use WTFramework\SQL\Grammars\PostgreSQL\Helpers\Upsert;
use WTFramework\SQL\Interfaces\HasBindings;

class PostgreSQL extends Connection
{

  public static function dsn(#[\SensitiveParameter] array $config): string
  {

    foreach ([
      'host',
      'port',
      'dbname',
      'sslmode'
    ] as $key)
    {

      $config[$key] ??= '';

      $$key = $config[$key] ? "$key={$config[$key]}" : '';

    }

    $dsn = implode(';', array_filter([
      $host,
      $port,
      $dbname,
      $sslmode
    ]));

    return "pgsql:$dsn";

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

  public function dropIndex(string|array $index): DropIndex
  {
    return new DropIndex(connection: $this, index: $index);
  }

  public function insert(string|HasBindings|array $table = null): Insert
  {
    return new Insert(connection: $this, table: $table);
  }

  public function replace(string|HasBindings|array $table = null): never
  {
    throw new BadMethodCallException("PostgreSQL does not support REPLACE statements.");
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
    throw new BadMethodCallException("PostgreSQL does not support indexes.");
  }

  public static function partition(string $name): never
  {
    throw new BadMethodCallException("PostgreSQL does not support partitions.");
  }

  public static function subpartition(string $name): never
  {
    throw new BadMethodCallException("PostgreSQL does not support subpartitions.");
  }

  public static function subquery(string|HasBindings $stmt): Subquery
  {
    return new Subquery(stmt: $stmt);
  }

  public static function table(string $name): Table
  {
    return new Table(name: $name);
  }

  public static function upsert(): Upsert
  {
    return new Upsert;
  }

}