<?php

declare(strict_types=1);

use WTFramework\DBAL\Drivers\MariaDB;
use WTFramework\DBAL\Drivers\MySQL;
use WTFramework\DBAL\Drivers\PostgreSQL;
use WTFramework\DBAL\Drivers\SQLite;
use WTFramework\DBAL\Drivers\SQLServer;
use WTFramework\SQL\Grammar;

it('can get mariadb grammar', function ()
{

  expect(MariaDB::$grammar)
  ->toBe(Grammar::MariaDB);

});

it('can get mariadb dsn', function ()
{

  expect(MariaDB::dsn([
    'host' => 'localhost',
    'port' => 3306,
    'dbname' => 'database',
    'unix_socket' => '',
    'charset' => 'utf8mb4',
  ]))
  ->toBe('mysql:host=localhost;port=3306;dbname=database;charset=utf8mb4');

});

it('can get mariadb dsn with unix socket', function ()
{

  expect(MariaDB::dsn([
    'host' => 'localhost',
    'port' => 3306,
    'dbname' => 'database',
    'unix_socket' => '/tmp/mysql.sock',
    'charset' => 'utf8mb4',
  ]))
  ->toBe('mysql:unix_socket=/tmp/mysql.sock;dbname=database;charset=utf8mb4');

});

it('can get mysql grammar', function ()
{

  expect(MySQL::$grammar)
  ->toBe(Grammar::MySQL);

});

it('can get mysql dsn', function ()
{

  expect(MySQL::dsn([
    'host' => 'localhost',
    'port' => 3306,
    'dbname' => 'database',
    'unix_socket' => '',
    'charset' => 'utf8mb4',
  ]))
  ->toBe('mysql:host=localhost;port=3306;dbname=database;charset=utf8mb4');

});

it('can get mysql dsn with unix socket', function ()
{

  expect(MySQL::dsn([
    'host' => 'localhost',
    'port' => 3306,
    'dbname' => 'database',
    'unix_socket' => '/tmp/mysql.sock',
    'charset' => 'utf8mb4',
  ]))
  ->toBe('mysql:unix_socket=/tmp/mysql.sock;dbname=database;charset=utf8mb4');

});

it('can get pgsql grammar', function ()
{

  expect(PostgreSQL::$grammar)
  ->toBe(Grammar::PostgreSQL);

});

it('can get pgsql dsn', function ()
{

  expect(PostgreSQL::dsn([
    'host' => 'localhost',
    'port' => 3306,
    'dbname' => 'database',
    'sslmode' => 'prefer',
  ]))
  ->toBe('pgsql:host=localhost;port=3306;dbname=database;sslmode=prefer');

});

it('can get sqlite grammar', function ()
{

  expect(SQLite::$grammar)
  ->toBe(Grammar::SQLite);

});

it('can get sqlite dsn', function ()
{

  expect(SQLite::dsn([
    'database' => ':memory:',
  ]))
  ->toBe('sqlite::memory:');

});

it('can get sqlsrv grammar', function ()
{

  expect(SQLServer::$grammar)
  ->toBe(Grammar::TSQL);

});

it('can get sqlsrv dsn', function ()
{

  expect(SQLServer::dsn([
    'Server' => 'localhost',
    'Database' => 'database',
  ]))
  ->toBe('sqlsrv:Server=localhost;Database=database');

});