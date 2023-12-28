# What the Framework?! DBAL

## SQLServer

### Configuration

Use the [Config](https://github.com/wtframework/config) library to set the database configuration settings.

```php
use WTFramework\Config\Config;
use WTFramework\DBAL\Connections\SQLServer;

Config::set([
  'database' => [
    'default' => 'sqlsrv',
    'connections' => [
      'sqlsrv' => [
        'connection' => SQLServer::class,
        'username' => 'username',
        'password' => 'password',
        'Server' => '127.0.0.1',
        'Database' => 'database',
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

`connection`\
The PDO driver and SQL syntax to use. For SQLServer this will be `WTFramework\DBAL\Connections\SQLServer::class`.

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

### How to use

Each of these static methods will return a fluent interface for generating SQL statement strings. See the [SQL](https://github.com/wtframework/sql/blob/main/docs/sqlserver.md) library for documentation on its methods.

```php
use WTFramework\DBAL\DB;

DB::select();
DB::insert();
DB::update();
DB::delete();
DB::truncate();

DB::create();
DB::alter();
DB::drop();
DB::createIndex();
DB::dropIndex();
```

Each of these static methods will return a helper class. See the [SQL](https://github.com/wtframework/sql/blob/main/docs/sqlserver.md) library for documentation on its methods.

```php
DB::column();
DB::constraint();
DB::cte();
DB::subquery();
DB::table();
```