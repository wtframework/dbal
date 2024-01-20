<?php

declare(strict_types=1);

namespace WTFramework\DBAL\Interfaces;

interface DB
{
  public static function connection(string $name = null): Connection;
}