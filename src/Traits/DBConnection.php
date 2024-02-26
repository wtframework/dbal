<?php

declare(strict_types=1);

namespace WTFramework\DBAL\Traits;

use Closure;
use stdClass;
use WTFramework\DBAL\Response;
use WTFramework\SQL\Statement;

trait DBConnection
{

  public static function unprepared(string|Statement $stmt): Response
  {
    return static::connection()->unprepared($stmt);
  }

  public static function prepare(
    string|Statement $stmt,
    string|int|array $bindings = null
  ): Response
  {
    return static::connection()->prepare($stmt, $bindings);
  }

  public static function execute(
    string|Statement $stmt,
    string|int|array $bindings = null
  ): Response
  {
    return static::prepare($stmt, $bindings)->execute();
  }

  public static function get(
    string|Statement $stmt,
    string|int|array $bindings = null
  ): ?stdClass
  {
    return static::execute($stmt, $bindings)->get();
  }

  public static function all(
    string|Statement $stmt,
    string|int|array $bindings = null
  ): array
  {
    return static::execute($stmt, $bindings)->all();
  }

  public static function affectedRows(
    string|Statement $stmt,
    string|int|array $bindings = null
  ): int
  {
    return static::execute($stmt, $bindings)->affectedRows();
  }

  public static function insertID(string $name = null): int
  {
    return static::connection()->insertID($name);
  }

  public static function transaction(Closure $callback): void
  {
    static::connection()->transaction($callback);
  }

  public static function beginTransaction(): void
  {
    static::connection()->beginTransaction();
  }

  public static function commit(): void
  {
    static::connection()->commit();
  }

  public static function rollBack(): void
  {
    static::connection()->rollBack();
  }

  public static function logs(): array
  {
    return static::connection()->logs();
  }

  public static function clearLogs(): void
  {
    static::connection()->clearLogs();
  }

}