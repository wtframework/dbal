<?php

declare(strict_types=1);

namespace WTFramework\DBAL\Interfaces;

use Closure;
use PDO;
use stdClass;
use WTFramework\DBAL\Response;
use WTFramework\SQL\Statement;

interface Connection
{
  public function __construct(PDO $pdo);
  public static function connect(#[\SensitiveParameter] array $config = []): static;
  public function unprepared(string|Statement $stmt): Response;
  public function prepare(
    string|Statement $stmt,
    string|int|array $bindings = null
  ): Response;
  public function execute(
    string|Statement $stmt,
    string|int|array $bindings = null
  ): Response;
  public function get(
    string|Statement $stmt,
    string|int|array $bindings = null
  ): ?stdClass;
  public function all(
    string|Statement $stmt,
    string|int|array $bindings = null
  ): array;
  public function affectedRows(
    string|Statement $stmt,
    string|int|array $bindings = null
  ): int;
  public function insertID(string $name = null): int;
  public function transaction(Closure $callback): void;
  public function beginTransaction(): void;
  public function commit(): void;
  public function rollBack(): void;
}