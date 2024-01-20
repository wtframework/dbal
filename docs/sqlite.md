# What the Framework?! DBAL

## SQLite

### Configuration

Use the [Config](https://github.com/wtframework/config) library to set the database configuration settings.

```php
use WTFramework\Config\Config;
use WTFramework\DBAL\Drivers\SQLite;

Config::set([
  'database' => [
    'default' => 'sqlite',
    'connections' => [
      'sqlite' => [
        'driver' => SQLite::class,
        'database' => ':memory:',
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

See [PDO_SQLITE DSN](https://www.php.net/manual/en/ref.pdo-sqlite.connection.php) for more information.

`driver`\
The PDO driver to use. For SQLite this will be `WTFramework\DBAL\Drivers\SQLite::class`.

`database`