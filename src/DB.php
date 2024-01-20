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
use WTFramework\SQL\Services\Index;
use WTFramework\SQL\Services\Outfile;
use WTFramework\SQL\Services\Partition;
use WTFramework\SQL\Services\Raw;
use WTFramework\SQL\Services\Subpartition;
use WTFramework\SQL\Services\Subquery;
use WTFramework\SQL\Services\Table;
use WTFramework\SQL\Services\Upsert;
use WTFramework\SQL\Services\Window;

abstract class DB implements InterfacesDB
{

  use DBConnection;

  public static function connection(string $name = null): Connection
  {
    return ConnectionContainer::connection($name, Connection::class);
  }

  public static function alter(): Alter
  {
    return static::connection()->alter();
  }

  public static function create(): Create
  {
    return static::connection()->create();
  }

  public static function createIndex(string $index): CreateIndex
  {
    return static::connection()->createIndex($index);
  }

  public static function delete(): Delete
  {
    return static::connection()->delete();
  }

  public static function drop(): Drop
  {
    return static::connection()->drop();
  }

  public static function dropIndex(string|HasBindings|array $index): DropIndex
  {
    return static::connection()->dropIndex($index);
  }

  public static function insert(): Insert
  {
    return static::connection()->insert();
  }

  public static function replace(): Replace
  {
    return static::connection()->replace();
  }

  public static function select(): Select
  {
    return static::connection()->select();
  }

  public static function truncate(): Truncate
  {
    return static::connection()->truncate();
  }

  public static function update(): Update
  {
    return static::connection()->update();
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

  public static function index(string $name = ''): Index
  {
    return static::connection()->index($name);
  }

  public static function outfile(string $path): Outfile
  {
    return static::connection()->outfile($path);
  }

  public static function partition(string $name): Partition
  {
    return static::connection()->partition($name);
  }

  public static function raw(string $string): Raw
  {
    return static::connection()->raw($string);
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