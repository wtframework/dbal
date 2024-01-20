<?php

declare(strict_types=1);

namespace WTFramework\DBAL\Drivers;

use WTFramework\DBAL\Driver;
use WTFramework\SQL\Grammar;
use WTFramework\SQL\Interfaces\IsGrammar;

abstract class SQLite extends Driver
{

  public static IsGrammar $grammar = Grammar::SQLite;

  public static function dsn(#[\SensitiveParameter] array $config): string
  {

    $database = $config['database'] ?? '';

    return "sqlite:$database";

  }

}