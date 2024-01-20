<?php

declare(strict_types=1);

namespace WTFramework\DBAL;

use PDO;
use PDOStatement;
use stdClass;

class Response
{

  public function __construct(
    public readonly PDOStatement $stmt,
    string|int|array $bindings = null
  )
  {

    if (null !== $bindings)
    {
      $this->bind($bindings);
    }

  }

  public function bind(string|int|array $bindings): static
  {

    foreach ((array) $bindings as $i => $binding)
    {
      $this->stmt->bindValue(++$i, $binding);
    }

    return $this;

  }

  public function execute(): static
  {

    $this->stmt->execute();

    return $this;

  }

  public function get(): ?stdClass
  {
    return $this->stmt->fetch(PDO::FETCH_OBJ) ?: null;
  }

  public function all(): array
  {
    return $this->stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function affectedRows(): int
  {
    return $this->stmt->rowCount();
  }

}