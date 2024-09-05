# What the Framework?! DBAL

## SQLServer

### Configuration

Use the [Config](https://github.com/wtframework/config) library to set the database configuration settings.

```php
use WTFramework\Config\Config;
use WTFramework\DBAL\Drivers\SQLServer;

Config::set([
  'database' => [
    'default' => 'sqlsrv',
    'connections' => [
      'sqlsrv' => [
        'driver' => SQLServer::class,
        'username' => 'username',
        'password' => 'password',
        'Server' => '127.0.0.1',
        'Database' => 'database',
        'options' => [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ],
      ],
    ],
  ],
]);
```

### Settings

`database`\
The route database setting.

`database.default`\
The named connection to use by default.

`database.connections`\
An array of named connections.

`database.connections.[name]`\
An array of connection details.

### Connection details

See [PDO_SQLSRV DSN](https://www.php.net/manual/en/ref.pdo-sqlsrv.connection.php) for more information.

`driver`\
The PDO driver to use. For SQLServer this will be `WTFramework\DBAL\Drivers\SQLServer::class`.

`username`\
The username.

`password`\
The password.

`APP`\
`ConnectionPooling`\
`Database`\
`Encrypt`\
`Failover_Partner`\
`LoginTimeout`\
`MultipleActiveResultSets`\
`QuotedId`\
`Server`\
`TraceFile`\
`TraceOn`\
`TransactionIsolation`\
`TrustServerCertificate`\
`WSID`