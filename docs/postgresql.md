# What the Framework?! DBAL

## PostgreSQL

### Configuration

Use the [Config](https://github.com/wtframework/config) library to set the database configuration settings.

```php
use WTFramework\Config\Config;
use WTFramework\DBAL\Drivers\PostgreSQL;

Config::set([
  'database' => [
    'default' => 'pgsql',
    'connections' => [
      'pgsql' => [
        'driver' => PostgreSQL::class,
        'username' => 'username',
        'password' => 'password',
        'host' => '127.0.0.1',
        'port' => 5432,
        'dbname' => 'database',
        'sslmode' => 'prefer',
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

See [PDO_PGSQL DSN](https://www.php.net/manual/en/ref.pdo-pgsql.connection.php) for more information.

`driver`\
The PDO driver to use. For PostgreSQL this will be `WTFramework\DBAL\Drivers\PostgreSQL::class`.

`username`\
The username.

`password`\
The password.

`host`\
`port`\
`dbname`\
`sslmode`