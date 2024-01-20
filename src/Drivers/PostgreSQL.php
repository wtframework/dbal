<?php

declare(strict_types=1);

namespace WTFramework\DBAL\Drivers;

use WTFramework\DBAL\Driver;
use WTFramework\SQL\Grammar;
use WTFramework\SQL\Interfaces\IsGrammar;

abstract class PostgreSQL extends Driver
{

  public static IsGrammar $grammar = Grammar::PostgreSQL;

  public static function dsn(#[\SensitiveParameter] array $config): string
  {

    foreach ([
      'host',
      'port',
      'dbname',
      'sslmode'
    ] as $key)
    {

      $config[$key] ??= '';

      $$key = $config[$key] ? "$key={$config[$key]}" : '';

    }

    $dsn = implode(';', array_filter([
      $host,
      $port,
      $dbname,
      $sslmode
    ]));

    return "pgsql:$dsn";

  }

}