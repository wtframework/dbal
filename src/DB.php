<?php

declare(strict_types=1);

namespace WTFramework\DBAL;

use Closure;
use stdClass;
use UnexpectedValueException;
use WTFramework\Config\Config;
use WTFramework\DBAL\Connections\SQLite;
use WTFramework\DBAL\Interfaces\Connection as InterfacesConnection;
use WTFramework\SQL\Helpers\Column;
use WTFramework\SQL\Helpers\Constraint;
use WTFramework\SQL\Helpers\CTE;
use WTFramework\SQL\Helpers\Index;
use WTFramework\SQL\Helpers\Partition;
use WTFramework\SQL\Helpers\Subpartition;
use WTFramework\SQL\Helpers\Subquery;
use WTFramework\SQL\Helpers\Table;
use WTFramework\SQL\Helpers\Upsert;
use WTFramework\SQL\Interfaces\HasBindings;
use WTFramework\SQL\SQL;
use WTFramework\SQL\Statement;
use WTFramework\SQL\Statements\Alter;
use WTFramework\SQL\Statements\Create;
use WTFramework\SQL\Statements\CreateIndex;
use WTFramework\SQL\Statements\Delete;
use WTFramework\SQL\Statements\Drop;
use WTFramework\SQL\Statements\DropIndex;
use WTFramework\SQL\Statements\Insert;
use WTFramework\SQL\Statements\Replace;
use WTFramework\SQL\Statements\Select;
use WTFramework\SQL\Statements\Truncate;
use WTFramework\SQL\Statements\Update;

abstract class DB extends SQL
{

  protected static ?array $config = null;
  protected static array $connections = [];

  public static function connection(string $name = null): Connection
  {

    $config = self::config($name);

    $connection = $config['connection'] ?? SQLite::class;

    return self::$connections[$name] ??= $connection::connect(
      config: $config
    );

  }

  protected static function config(string &$name = null): array
  {

    self::$config ??= (array) Config::get(key: 'database');

    $name ??= self::$config['default'] ?? '';

    return self::$config['connections'][$name] ?? throw new UnexpectedValueException(
      "Unknown database connection '$name'"
    );

  }

  public static function alter(string|HasBindings|array $table = null): Alter & InterfacesConnection
  {
    return self::connection()->alter(table: $table);
  }

  public static function create(string|HasBindings|array $table = null): Create & InterfacesConnection
  {
    return self::connection()->create(table: $table);
  }

  public static function createIndex(string $index): CreateIndex & InterfacesConnection
  {
    return self::connection()->createIndex(index: $index);
  }

  public static function delete(string|HasBindings|array $table = null): Delete & InterfacesConnection
  {
    return self::connection()->delete(table: $table);
  }

  public static function drop(string|HasBindings|array $table = null): Drop & InterfacesConnection
  {
    return self::connection()->drop(table: $table);
  }

  public static function dropIndex(string $index): DropIndex & InterfacesConnection
  {
    return self::connection()->dropIndex(index: $index);
  }

  public static function insert(string|HasBindings|array $table = null): Insert & InterfacesConnection
  {
    return self::connection()->insert(table: $table);
  }

  public static function replace(string|HasBindings|array $table = null): Replace & InterfacesConnection
  {
    return self::connection()->replace(table: $table);
  }

  public static function select(string|HasBindings|array $table = null): Select & InterfacesConnection
  {
    return self::connection()->select(table: $table);
  }

  public static function truncate(string|HasBindings $table = null): Truncate & InterfacesConnection
  {
    return self::connection()->truncate(table: $table);
  }

  public static function update(string|HasBindings|array $table = null): Update & InterfacesConnection
  {
    return self::connection()->update(table: $table);
  }

  public static function column(string $name): Column
  {
    return self::connection()::column(name: $name);
  }

  public static function constraint(string $name): Constraint
  {
    return self::connection()::constraint(name: $name);
  }

  public static function cte(
    string $name,
    string|HasBindings $stmt
  ): CTE
  {

    return self::connection()::cte(
      name: $name,
      stmt: $stmt
    );

  }

  public static function index(string $name): Index
  {
    return self::connection()::index(name: $name);
  }

  public static function partition(string $name): Partition
  {
    return self::connection()::partition(name: $name);
  }

  public static function subpartition(string $name): Subpartition
  {
    return self::connection()::subpartition(name: $name);
  }

  public static function subquery(string|HasBindings $stmt): Subquery
  {
    return self::connection()::subquery(stmt: $stmt);
  }

  public static function table(string $name): Table
  {
    return self::connection()::table(name: $name);
  }

  public static function upsert(): Upsert
  {
    return self::connection()::upsert();
  }

  public static function unprepared(string|Statement $stmt): Response
  {
    return self::connection()->unprepared(stmt: $stmt);
  }

  public static function prepare(
    string|Statement $stmt,
    string|int|array $bindings = null
  ): Response
  {

    return self::connection()->prepare(
      stmt: $stmt,
      bindings: $bindings
    );

  }

  public static function execute(
    string|Statement $stmt,
    string|int|array $bindings = null
  ): Response
  {

    return self::prepare(
      stmt: $stmt,
      bindings: $bindings
    )->execute();

  }

  public static function get(
    string|Statement $stmt,
    string|int|array $bindings = null
  ): ?stdClass
  {

    return self::execute(
      stmt: $stmt,
      bindings: $bindings
    )->get();

  }

  public static function all(
    string|Statement $stmt,
    string|int|array $bindings = null
  ): array
  {

    return self::execute(
      stmt: $stmt,
      bindings: $bindings
    )->all();

  }

  public static function insertID(string $name = null): int
  {
    return self::connection()->insertID(name: $name);
  }

  public static function transaction(Closure $callback): void
  {
    self::connection()->transaction(callback: $callback);
  }

  public static function beginTransaction(): void
  {
    self::connection()->beginTransaction();
  }

  public static function commit(): void
  {
    self::connection()->commit();
  }

  public static function rollBack(): void
  {
    self::connection()->rollBack();
  }

  public static function stmts(): array
  {
    return self::connection()->stmts();
  }

  public static function clearStmts(): void
  {
    self::connection()->clearStmts();
  }

}