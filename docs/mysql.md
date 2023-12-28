# What the Framework?! DBAL

## MySQL

### Configuration

Use the [Config](https://github.com/wtframework/config) library to set the database configuration settings.

```php
use WTFramework\Config\Config;
use WTFramework\DBAL\Connections\MySQL;

Config::set([
  'database' => [
    'default' => 'mysql',
    'connections' => [
      'mysql' => [
        'connection' => MySQL::class,
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

`connection`\
The PDO driver and SQL syntax to use. For MySQL this will be `WTFramework\DBAL\Connections\MySQL::class`.

`username`\
The username.

`password`\
The password.

`host`\
`port`\
`dbname`\
`unix_socket`\
`charset`

### How to use

Each of these static methods will return a fluent interface for generating SQL statement strings. See the [SQL](https://github.com/wtframework/sql/blob/main/docs/mysql.md) library for documentation on its methods.

```php
use WTFramework\DBAL\DB;

DB::select();
DB::insert();
DB::replace();
DB::update();
DB::delete();
DB::truncate();

DB::create();
DB::alter();
DB::drop();
DB::createIndex();
DB::dropIndex();
```

Each of these static methods will return a helper class. See the [SQL](https://github.com/wtframework/sql/blob/main/docs/mysql.md) library for documentation on its methods.

```php
DB::column();
DB::constraint();
DB::cte();
DB::index();
DB::partition();
DB::subpartition();
DB::subquery();
DB::table();
```