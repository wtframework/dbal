# What the Framework?! DBAL

## SQLite

### Configuration

Use the [Config](https://github.com/wtframework/config) library to set the database configuration settings.

```php
use WTFramework\Config\Config;
use WTFramework\DBAL\Connections\SQLite;

Config::set([
  'database' => [
    'default' => 'sqlite',
    'connections' => [
      'sqlite' => [
        'connection' => SQLite::class,
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

`connection`\
The PDO driver and SQL syntax to use. For SQLite this will be `WTFramework\DBAL\Connections\SQLite::class`.

`database`

### How to use

Each of these static methods will return a fluent interface for generating SQL statement strings. See the [SQL](https://github.com/wtframework/sql/blob/main/docs/sqlite.md) library for documentation on its methods.

```php
use WTFramework\DBAL\DB;

DB::select();
DB::insert();
DB::replace();
DB::update();
DB::delete();

DB::create();
DB::alter();
DB::drop();
DB::createIndex();
DB::dropIndex();
```

Each of these static methods will return a helper class. See the [SQL](https://github.com/wtframework/sql/blob/main/docs/sqlite.md) library for documentation on its methods.

```php
DB::column();
DB::constraint();
DB::cte();
DB::subquery();
DB::table();
DB::upsert();
```