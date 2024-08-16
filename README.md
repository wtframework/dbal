# What the Framework?! DBAL
This library extends the [SQL](https://github.com/wtframework/sql) library with a wrapper for PDO.

The [ORM](https://github.com/wtframework/orm) library extends this library to provide object–relational mapping.

## Installation
```bash
composer require wtframework/dbal
```

## Documentation

### Configuration
[MariaDB](docs/mariadb.md)\
[MySQL](docs/mysql.md)\
[SQLite](docs/sqlite.md)\
[PostgreSQL](docs/postgresql.md)\
[SQL Server](docs/sqlserver.md)

### Executing an unprepared statement
Use the `unprepared` method to execute an unprepared statement.
```php
$response = DB::unprepared("SELECT * FROM users");

$response = DB::select()->from("users")->unprepared();
```

### Preparing a statement
Use the `prepare` method to prepare a statement.
```php
$response = DB::prepare("SELECT * FROM users WHERE user_id = ?");

$response = DB::select()->from("users")->where("user_id", "?")->prepare();
```
\
Use the `bind` method to bind any parameters.
```php
$response->bind(1);
```
\
Use the `execute` method to execute the statement
```php
$response->execute();
```

### Preparing and executing a statement
Use the `execute` method to prepare and execute a statement.
```php
$response = DB::execute("SELECT * FROM users WHERE user_id = ?", 1);

$response = DB::select()->from("users")->where("user_id", 1)->execute();
```
\
When using the statement builder you may also execute the statement by calling it as a function.
```php
DB::insert()->into("users")();
```

### Retrieving a result set
Use the `get` method to return a single row result set.
```php
DB::get("SELECT * FROM users WHERE user_id = ?", 1);

DB::select()->from("users")->where("user_id", 1)->get();
```
\
You may also use the `get` method on any response.
```php
$response->get();
```
\
Use the `all` method to return the result set as an array.
```php
DB::all("SELECT * FROM users");

DB::select()->from("users")->all();
```
\
You may also use the `all` method on any response.
```php
$response->all();
```

### Miscellaneous
Use the `insertID` method after executing a statement to return the last insert ID.
```php
DB::insert()->into("users")->execute();

DB::insertID();
```
\
Use the `affectedRows` method after executing a statement to return the number of rows inserted or updated.
```php
$response = DB::update()->table("users")->set('active', 1)->execute();

$response->affectedRows();
```

### Transactions
Use the `beginTransaction`, `commit`, and `rollback` methods to perform transactions.
```php
DB::beginTransaction();
DB::commit();
DB::rollBack();
```
\
You may also use the `transaction` method to automatically begin a transaction that will commit on success or roll back on failure.
```php
DB::transaction(function ()
{

  DB::insert()->into("users")->execute();

  // ...

});
```

### Using a non-default database connection
If you have more than one connection and wish to use a non-default connection then you may use the `connection` method passing it the connection name. This will return an instance of `WTFramework\DBAL\Connection` which shares the same methods as those documented above.
```php
$response = DB::connection("mirror")->select()->from("users")->where("user_id", 1)->get();
```

### Statements
Each of these static methods will return a fluent interface for generating SQL statement strings. See the [SQL](https://github.com/wtframework/sql) library for further documentation.

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
DB::createIndex($name);
DB::dropIndex($name);
```

### Services
Each of these static methods will return a service class. See the [SQL](https://github.com/wtframework/sql) library for further documentation.

```php
DB::bind($value);
DB::column($name);
DB::constraint($name);
DB::cte($name, $stmt);
DB::index($name);
DB::outfile($path);
DB::partition($name);
DB::raw($string);
DB::subpartition($name);
DB::subquery($stmt);
DB::table($name);
DB::upsert();
DB::window($name);
```

## Extending the library
To extend the library you can use the static `macro` method, passing the new method name and a closure to call. This works for both static and non-static methods. This is available on the `DB`, `Connection`, and `Response` classes.
```php
use WTFramework\DB\DB;

DB::macro('count', function (string $table)
{

  return static::select()
  ->column('COUNT(*) AS counter')
  ->from($table)
  ->get()
  ->counter;

});
```
```php
DB::count('users');
```