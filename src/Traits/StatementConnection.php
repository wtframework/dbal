<?php

declare(strict_types=1);

namespace WTFramework\DBAL\Traits;

use WTFramework\DBAL\Interfaces\Connection;
use WTFramework\DBAL\Response;

trait StatementConnection
{

  public function __construct(
    public readonly Connection $connection,
    ...$params
  )
  {
    parent::__construct(...$params);
  }

  public function unprepared(): Response
  {
    return $this->connection->unprepared($this);
  }

  public function prepare(): Response
  {
    return $this->connection->prepare($this);
  }

  public function execute(): Response
  {
    return $this->prepare()->execute();
  }

  public function get(): ?object
  {
    return $this->execute()->get();
  }

  public function all(): array
  {
    return $this->execute()->all();
  }

  public function affectedRows(): int
  {
    return $this->execute()->affectedRows();
  }

  public function __invoke(): Response
  {
    return $this->execute();
  }

}