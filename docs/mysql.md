# What the Framework?! DBAL

## MySQL

### Configuration

Use the [Config](https://github.com/wtframework/config) library to set the database configuration settings.

```php
use WTFramework\Config\Config;
use WTFramework\DBAL\Drivers\MySQL;

Config::set([
  'database' => [
    'default' => 'mysql',
    'connections' => [
      'mysql' => [
        'driver' => MySQL::class,
        'username' => 'username',
        'password' => 'password',
        'host' => '127.0.0.1',
        'port' => 3306,
        'dbname' => 'database',
        'unix_socket' => '',
        'charset' => 'utf8mb4',
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

See [PDO_MYSQL DSN](https://www.php.net/manual/en/ref.pdo-mysql.connection.php) for more information.

`driver`\
The PDO driver to use. For MySQL this will be `WTFramework\DBAL\Drivers\MySQL::class`.

`username`\
The username.

`password`\
The password.

`host`\
`port`\
`dbname`\
`unix_socket`\
`charset`