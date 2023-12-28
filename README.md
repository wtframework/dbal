# What the Framework?! DBAL

This library extends the [SQL](https://github.com/wtframework/sql) library with a simple wrapper for PDO.

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

### `WTFramework\DBAL\DB`

Execute an unprepared statement using the `unprepared` method. This will return an instance of `WTFramework\DBAL\Response`.

```php
DB::unprepared("SELECT * FROM users");

DB::select("users")->unprepared();
```

Prepare a statement using the `prepare` method. This will return an instance of `WTFramework\DBAL\Response`.

```php
DB::prepare("SELECT * FROM users WHERE user_id = ?", 1);

DB::select("users")->where("user_id", 1)->prepare();
```

Prepare and execute a statement using the `execute` method. This will return an instance of `WTFramework\DBAL\Response`.

```php
DB::execute("SELECT * FROM users WHERE user_id = ?", 1);

DB::select("users")->where("user_id", 1)->execute();
```

Return a single row result set as an object using the `get` method.

```php
DB::get("SELECT * FROM users WHERE user_id = ?", 1);

DB::select("users")->where("user_id", 1)->get();
```

Return the result set as an array using the `all` method.

```php
DB::all("SELECT * FROM users");

DB::select("users")->all();
```

Return the last insert ID using the `insertID` method.

```php
DB::insert("users")->execute();

DB::insertID();
```

### `WTFramework\DBAL\Response`

```php
$response->execute();
$response->get();
$response->all();
$response->affectedRows();
```

### Transactions

```php
DB::beginTransaction();
DB::commit();
DB::rollBack();
```

You may also use the `transaction` method to automatically begin a transaction that will commit on success or roll back on failure.

```php
DB::transaction(function ()
{

  DB::insert("users")->execute();

  // ...

});
```

### Using a non-default database connection

If you have more than one connection and wish to use a non-default connection then you may use the `connection` method passing it the connection name. This will return an instance of `WTFramework\DBAL\Connection` which shares the same methods as those documented above.

```php
DB::connection("mirror")->select("users")->where("user_id", 1)->get();
```

## ORM

The [ORM](https://github.com/wtframework/orm) library extends the DBAL library to provide object–relational mapping.