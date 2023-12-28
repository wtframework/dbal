<?php

declare(strict_types=1);

namespace WTFramework\DBAL;

use PDO;
use PDOStatement;
use stdClass;

class Response
{

  public function __construct(public readonly PDOStatement $stmt) {}

  public function bind(string|int|array $bindings): self
  {

    foreach ((array) $bindings as $i => $binding)
    {

      ++$i;

      match (true)
      {

        !is_array($binding) => $this->stmt->bindValue(
          $i,
          $binding
        ),

        array_key_exists('value', $binding) => $this->stmt->bindValue(
          $i,
          ...$binding
        ),

        array_key_exists('var', $binding) => $this->stmt->bindParam(
          $i,
          ...$binding
        ),

      };

    }

    return $this;

  }

  public function execute(): self
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