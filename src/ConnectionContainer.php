<?php

declare(strict_types=1);

namespace WTFramework\DBAL;

use WTFramework\Config\Config;
use WTFramework\DBAL\Exceptions\UnknownConnection;
use WTFramework\DBAL\Interfaces\Connection;

abstract class ConnectionContainer
{

  protected static ?array $config = null;
  protected static array $connections = [];

  public static function connection(
    ?string $name,
    string $connection,
    string $group = null
  ): Connection
  {

    $config = static::config($name);

    return static::$connections[$group][$name] ??= $connection::connect($config);

  }

  protected static function config(string &$name = null): array
  {

    static::$config ??= (array) Config::get('database');

    $name ??= static::$config['default'] ?? '';

    return static::$config['connections'][$name] ?? throw new UnknownConnection(
      "Unknown database connection '$name'"
    );

  }

}