<?php

declare(strict_types=1);

namespace WTFramework\DBAL\Connections;

use BadMethodCallException;
use WTFramework\DBAL\Connection;
use WTFramework\DBAL\Grammars\SQLite\Alter;
use WTFramework\DBAL\Grammars\SQLite\Create;
use WTFramework\DBAL\Grammars\SQLite\CreateIndex;
use WTFramework\DBAL\Grammars\SQLite\Delete;
use WTFramework\DBAL\Grammars\SQLite\Drop;
use WTFramework\DBAL\Grammars\SQLite\DropIndex;
use WTFramework\DBAL\Grammars\SQLite\Insert;
use WTFramework\DBAL\Grammars\SQLite\Replace;
use WTFramework\DBAL\Grammars\SQLite\Select;
use WTFramework\DBAL\Grammars\SQLite\Update;
use WTFramework\SQL\Grammars\SQLite\Helpers\Column;
use WTFramework\SQL\Grammars\SQLite\Helpers\Constraint;
use WTFramework\SQL\Grammars\SQLite\Helpers\CTE;
use WTFramework\SQL\Grammars\SQLite\Helpers\Table;
use WTFramework\SQL\Grammars\SQLite\Helpers\Upsert;
use WTFramework\SQL\Helpers\Subquery;
use WTFramework\SQL\Interfaces\HasBindings;

class SQLite extends Connection
{

  public static function dsn(#[\SensitiveParameter] array $config): string
  {

    $database = $config['database'] ?? '';

    return "sqlite:$database";

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

  public function replace(string|HasBindings|array $table = null): Replace
  {
    return new Replace(connection: $this, table: $table);
  }

  public function select(string|HasBindings|array $table = null): Select
  {
    return new Select(connection: $this, table: $table);
  }

  public function truncate(string|HasBindings|array $table = null): never
  {
    throw new BadMethodCallException("SQLite does not support TRUNCATE statements.");
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
    throw new BadMethodCallException("SQLite does not support indexes.");
  }

  public static function partition(string $name): never
  {
    throw new BadMethodCallException("SQLite does not support partitions.");
  }

  public static function subpartition(string $name): never
  {
    throw new BadMethodCallException("SQLite does not support subpartitions.");
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