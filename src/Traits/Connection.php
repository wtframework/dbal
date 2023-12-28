<?php

declare(strict_types=1);

namespace WTFramework\DBAL\Traits;

use WTFramework\DBAL\Connection as DBALConnection;
use WTFramework\DBAL\Response;

trait Connection
{

  public function __construct(
    public readonly DBALConnection $connection,
    ...$params
  )
  {
    parent::__construct(...$params);
  }

  public function unprepared(): Response
  {
    return $this->connection->unprepared(stmt: $this);
  }

  public function prepare(): Response
  {
    return $this->connection->prepare(stmt: $this);
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

  public function __invoke(): Response
  {
    return $this->execute();
  }

}