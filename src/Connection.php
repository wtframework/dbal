<?php

declare(strict_types=1);

namespace WTFramework\DBAL;

use Closure;
use PDO;
use stdClass;
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

abstract class Connection
{

  protected array $stmts = [];

  public function __construct(public readonly PDO $pdo) {}

  public static function connect(#[\SensitiveParameter] array $config = []): static
  {

    return new static(pdo: new PDO(
      static::dsn(config: $config),
      $config['username'] ?? null,
      $config['password'] ?? null,
      [PDO::ATTR_EMULATE_PREPARES => false]
    ));

  }

  abstract public static function dsn(
    #[\SensitiveParameter] array $config
  ): string;

  abstract public function alter(string|HasBindings|array $table = null): Alter & InterfacesConnection;

  abstract public function create(string|HasBindings|array $table = null): Create & InterfacesConnection;

  abstract public function createIndex(string $index): CreateIndex & InterfacesConnection;

  abstract public function delete(string|HasBindings|array $table = null): Delete & InterfacesConnection;

  abstract public function drop(string|HasBindings|array $table = null): Drop & InterfacesConnection;

  abstract public function dropIndex(string $index): DropIndex & InterfacesConnection;

  abstract public function insert(string|HasBindings|array $table = null): Insert & InterfacesConnection;

  abstract public function replace(string|HasBindings|array $table = null): Replace & InterfacesConnection;

  abstract public function select(string|HasBindings|array $table = null): Select & InterfacesConnection;

  abstract public function truncate(string|HasBindings $table = null): Truncate & InterfacesConnection;

  abstract public function update(string|HasBindings|array $table = null): Update & InterfacesConnection;

  abstract public static function column(string $name): Column;

  abstract public static function constraint(string $name): Constraint;

  abstract public static function cte(
    string $name,
    string|HasBindings $stmt
  ): CTE;

  abstract public static function index(string $name): Index;

  abstract public static function partition(string $name): Partition;

  abstract public static function subpartition(string $name): Subpartition;

  abstract public static function subquery(string|HasBindings $stmt): Subquery;

  abstract public static function table(string $name): Table;

  abstract public static function upsert(): Upsert;

  public function unprepared(string|Statement $stmt): Response
  {
    return new Response(stmt: $this->pdo->query($this->log(stmt: $stmt)));
  }

  public function prepare(
    string|Statement $stmt,
    string|int|array $bindings = null
  ): Response
  {

    $response = new Response(stmt: $this->pdo->prepare($this->log(stmt: $stmt)));

    if ($stmt instanceof HasBindings)
    {
      $bindings = $stmt->bindings();
    }

    if (null !== $bindings)
    {
      $response->bind(bindings: $bindings);
    }

    return $response;

  }

  public function execute(
    string|Statement $stmt,
    string|int|array $bindings = null
  ): Response
  {

    return $this->prepare(
      stmt: $stmt,
      bindings: $bindings
    )->execute();

  }

  public function get(
    string|Statement $stmt,
    string|int|array $bindings = null
  ): ?stdClass
  {

    return $this->execute(
      stmt: $stmt,
      bindings: $bindings
    )->get();

  }

  public function all(
    string|Statement $stmt,
    string|int|array $bindings = null
  ): array
  {

    return $this->execute(
      stmt: $stmt,
      bindings: $bindings
    )->all();

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

    catch (\Exception $e)
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

  protected function log(string|Statement $stmt): string
  {

    $this->stmts[] = (object) [
      'stmt' => $string = (string) $stmt,
      'bindings' => $stmt instanceof HasBindings ? $stmt->bindings() : null,
    ];

    return $string;

  }

  public function stmts(): array
  {
    return $this->stmts;
  }

  public function clearStmts(): void
  {
    $this->stmts = [];
  }

}