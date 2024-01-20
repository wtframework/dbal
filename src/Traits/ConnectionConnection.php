<?php

declare(strict_types=1);

namespace WTFramework\DBAL\Traits;

use Closure;
use PDO;
use stdClass;
use Throwable;
use WTFramework\DBAL\Driver;
use WTFramework\DBAL\Response;
use WTFramework\SQL\Interfaces\HasBindings;
use WTFramework\SQL\Statement;
use WTFramework\SQL\Traits\UseGrammar;

trait ConnectionConnection
{

  use UseGrammar;

  public function __construct(public readonly PDO $pdo) {}

  public static function connect(#[\SensitiveParameter] array $config = []): static
  {

    $driver = $config['driver'] ?? Driver::DEFAULT_DRIVER;

    $connection = new static(new PDO(
      $driver::dsn($config),
      $config['username'] ?? null,
      $config['password'] ?? null,
      [PDO::ATTR_EMULATE_PREPARES => false]
    ));

    return $connection->use($driver::$grammar);

  }

  public function unprepared(string|Statement $stmt): Response
  {
    return new Response($this->pdo->query($stmt));
  }

  public function prepare(
    string|Statement $stmt,
    string|int|array $bindings = null
  ): Response
  {

    $sql = (string) $stmt;

    $bindings = $stmt instanceof HasBindings ? $stmt->bindings() : $bindings;

    return new Response($this->pdo->prepare($sql), $bindings);

  }

  public function execute(
    string|Statement $stmt,
    string|int|array $bindings = null
  ): Response
  {
    return $this->prepare($stmt, $bindings)->execute();
  }

  public function get(
    string|Statement $stmt,
    string|int|array $bindings = null
  ): ?stdClass
  {
    return $this->execute($stmt, $bindings)->get();
  }

  public function all(
    string|Statement $stmt,
    string|int|array $bindings = null
  ): array
  {
    return $this->execute($stmt, $bindings)->all();
  }

  public function affectedRows(
    string|Statement $stmt,
    string|int|array $bindings = null
  ): int
  {
    return $this->execute($stmt, $bindings)->affectedRows();
  }

  public function insertID(string $name = null): int
  {
    return (int) $this->pdo->lastInsertId($name);
  }

  public function transaction(Closure $callback): void
  {

    $this->beginTransaction();

    try
    {

      $callback($this);

      $this->commit();

    }

    catch (Throwable $e)
    {

      $this->rollBack();

      throw $e;

    }

  }

  public function beginTransaction(): void
  {
    $this->pdo->beginTransaction();
  }

  public function commit(): void
  {
    $this->pdo->commit();
  }

  public function rollBack(): void
  {
    $this->pdo->rollBack();
  }

}