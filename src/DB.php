<?php

declare(strict_types=1);

namespace WTFramework\DBAL;

use WTFramework\DBAL\Interfaces\DB as InterfacesDB;
use WTFramework\DBAL\Statements\Alter;
use WTFramework\DBAL\Statements\Create;
use WTFramework\DBAL\Statements\CreateIndex;
use WTFramework\DBAL\Statements\Delete;
use WTFramework\DBAL\Statements\Drop;
use WTFramework\DBAL\Statements\DropIndex;
use WTFramework\DBAL\Statements\Insert;
use WTFramework\DBAL\Statements\Replace;
use WTFramework\DBAL\Statements\Select;
use WTFramework\DBAL\Statements\Truncate;
use WTFramework\DBAL\Statements\Update;
use WTFramework\DBAL\Traits\DBConnection;
use WTFramework\SQL\Interfaces\HasBindings;
use WTFramework\SQL\Services\Column;
use WTFramework\SQL\Services\Constraint;
use WTFramework\SQL\Services\CTE;
use WTFramework\SQL\Services\ForeignKey;
use WTFramework\SQL\Services\Index;
use WTFramework\SQL\Services\Outfile;
use WTFramework\SQL\Services\Partition;
use WTFramework\SQL\Services\Raw;
use WTFramework\SQL\Services\Subpartition;
use WTFramework\SQL\Services\Subquery;
use WTFramework\SQL\Services\Table;
use WTFramework\SQL\Services\Upsert;
use WTFramework\SQL\Services\Window;
use WTFramework\SQL\Traits\Macroable;

abstract class DB implements InterfacesDB
{

  use DBConnection;
  use Macroable;

  public static function connection(string $name = null): Connection
  {
    return ConnectionContainer::connection($name, Connection::class);
  }

  public static function alter(string|HasBindings $table = null): Alter
  {
    return static::connection()->alter($table);
  }

  public static function create(string|HasBindings $table = null): Create
  {
    return static::connection()->create($table);
  }

  public static function createIndex(string $index): CreateIndex
  {
    return static::connection()->createIndex($index);
  }

  public static function delete(string|HasBindings|array $table = null): Delete
  {
    return static::connection()->delete($table);
  }

  public static function drop(string|HasBindings|array $table = null): Drop
  {
    return static::connection()->drop($table);
  }

  public static function dropIndex(string|HasBindings|array $index): DropIndex
  {
    return static::connection()->dropIndex($index);
  }

  public static function insert(string|HasBindings|array $table = null): Insert
  {
    return static::connection()->insert($table);
  }

  public static function replace(string|HasBindings|array $table = null): Replace
  {
    return static::connection()->replace($table);
  }

  public static function select(string|HasBindings|array $table = null): Select
  {
    return static::connection()->select($table);
  }

  public static function truncate(string|HasBindings|array $table = null): Truncate
  {
    return static::connection()->truncate($table);
  }

  public static function update(string|HasBindings|array $table = null): Update
  {
    return static::connection()->update($table);
  }

  public static function bind(string|int $value): Raw
  {
    return static::connection()->raw('?')->bind($value);
  }

  public static function column(string $name): Column
  {
    return static::connection()->column($name);
  }

  public static function constraint(string $name = ''): Constraint
  {
    return static::connection()->constraint($name);
  }

  public static function cte(
    string $name,
    string|HasBindings $stmt
  ): CTE
  {
    return static::connection()->cte($name, $stmt);
  }

  public static function foreignKey(string|array $column): ForeignKey
  {
    return static::connection()->foreignKey($column);
  }

  public static function index(
    string|array $column,
    string $name = ''
  ): Index
  {
    return static::connection()->index($column, $name);
  }

  public static function outfile(string $path): Outfile
  {
    return static::connection()->outfile($path);
  }

  public static function partition(string $name): Partition
  {
    return static::connection()->partition($name);
  }

  public static function raw(
    string $string,
    string|int|array $bindings = []
  ): Raw
  {
    return static::connection()->raw($string, $bindings);
  }

  public static function subpartition(string $name): Subpartition
  {
    return static::connection()->subpartition($name);
  }

  public static function subquery(string|HasBindings $stmt): Subquery
  {
    return static::connection()->subquery($stmt);
  }

  public static function table(string $name): Table
  {
    return static::connection()->table($name);
  }

  public static function upsert(): Upsert
  {
    return static::connection()->upsert();
  }

  public static function window(string $name = ''): Window
  {
    return static::connection()->window($name);
  }

}