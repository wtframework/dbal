<?php

declare(strict_types=1);

namespace WTFramework\DBAL\Drivers;

use WTFramework\DBAL\Driver;
use WTFramework\SQL\Grammar;
use WTFramework\SQL\Interfaces\IsGrammar;

abstract class SQLServer extends Driver
{

  public static IsGrammar $grammar = Grammar::TSQL;

  public static function dsn(#[\SensitiveParameter] array $config): string
  {

    foreach ([
      'Server',
      'Database',
      'APP',
      'ConnectionPooling',
      'Encrypt',
      'Failover_Partner',
      'LoginTimeout',
      'MultipleActiveResultSets',
      'QuotedId',
      'TraceFile',
      'TraceOn',
      'TransactionIsolation',
      'TrustServerCertificate',
      'WSID',
    ] as $key)
    {

      $config[$key] ??= '';

      $$key = $config[$key] ? "$key={$config[$key]}" : '';

    }

    $dsn = implode(';', array_filter([
      $Server,
      $Database,
      $APP,
      $ConnectionPooling,
      $Encrypt,
      $Failover_Partner,
      $LoginTimeout,
      $MultipleActiveResultSets,
      $QuotedId,
      $TraceFile,
      $TraceOn,
      $TransactionIsolation,
      $TrustServerCertificate,
      $WSID,
    ]));

    return "sqlsrv:$dsn";

  }

}