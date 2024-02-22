<?php

declare(strict_types=1);

namespace WTFramework\DBAL\Simple;

use WTFramework\DBAL\ConnectionContainer;
use WTFramework\DBAL\Interfaces\DB as InterfacesDB;
use WTFramework\DBAL\Traits\DBConnection;
use WTFramework\DBAL\Simple\Statements\Delete;
use WTFramework\DBAL\Simple\Statements\Insert;
use WTFramework\DBAL\Simple\Statements\Replace;
use WTFramework\DBAL\Simple\Statements\Select;
use WTFramework\DBAL\Simple\Statements\Truncate;
use WTFramework\DBAL\Simple\Statements\Update;
use WTFramework\SQL\Interfaces\HasBindings;
use WTFramework\SQL\Services\Raw;
use WTFramework\SQL\Services\Subquery;
use WTFramework\SQL\Services\Table;
use WTFramework\SQL\Services\Upsert;
use WTFramework\SQL\Traits\Macroable;

abstract class DB implements InterfacesDB
{

  use DBConnection;
  use Macroable;

  public static function connection(string $name = null): Connection
  {
    return ConnectionContainer::connection($name, Connection::class, 'simple');
  }

  public static function delete(): Delete
  {
    return static::connection()->delete();
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

  public static function raw(
    string $string,
    string|int|array $bindings = []
  ): Raw
  {
    return static::connection()->raw($string, $bindings);
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

}