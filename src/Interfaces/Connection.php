<?php

declare(strict_types=1);

namespace WTFramework\DBAL\Interfaces;

use WTFramework\DBAL\Response;

interface Connection
{
  public function unprepared(): Response;
  public function prepare(): Response;
  public function execute(): Response;
  public function get(): ?object;
  public function all(): array;
}