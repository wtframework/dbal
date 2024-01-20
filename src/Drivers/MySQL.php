<?php

declare(strict_types=1);

namespace WTFramework\DBAL\Drivers;

use WTFramework\DBAL\Driver;
use WTFramework\SQL\Grammar;
use WTFramework\SQL\Interfaces\IsGrammar;

abstract class MySQL extends Driver
{

  public static IsGrammar $grammar = Grammar::MySQL;

  public static function dsn(#[\SensitiveParameter] array $config): string
  {

    foreach ([
      'host',
      'port',
      'dbname',
      'unix_socket',
      'charset'
    ] as $key)
    {

      $config[$key] ??= '';

      $$key = $config[$key] ? "$key={$config[$key]}" : '';

    }

    $dsn = implode(';', array_filter([
      $unix_socket ?: $host,
      $unix_socket ? '' : $port,
      $dbname,
      $charset
    ]));

    return "mysql:$dsn";

  }

}