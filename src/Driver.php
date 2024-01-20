<?php

declare(strict_types=1);

namespace WTFramework\DBAL;

use WTFramework\DBAL\Drivers\SQLite;
use WTFramework\SQL\Grammar;
use WTFramework\SQL\Interfaces\IsGrammar;

abstract class Driver
{

  public const DEFAULT_DRIVER = SQLite::class;

  public static IsGrammar $grammar = Grammar::SQLite;

  abstract public static function dsn(#[\SensitiveParameter] array $config): string;

}