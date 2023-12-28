<?php

declare(strict_types=1);

use WTFramework\DBAL\Connection;
use WTFramework\DBAL\Connections\MySQL;
use WTFramework\DBAL\Grammars\MySQL\Alter;
use WTFramework\DBAL\Grammars\MySQL\Create;
use WTFramework\DBAL\Grammars\MySQL\CreateIndex;
use WTFramework\DBAL\Grammars\MySQL\Delete;
use WTFramework\DBAL\Grammars\MySQL\Drop;
use WTFramework\DBAL\Grammars\MySQL\DropIndex;
use WTFramework\DBAL\Grammars\MySQL\Insert;
use WTFramework\DBAL\Grammars\MySQL\Replace;
use WTFramework\DBAL\Grammars\MySQL\Select;
use WTFramework\DBAL\Grammars\MySQL\Truncate;
use WTFramework\DBAL\Grammars\MySQL\Update;

$pdo = new PDO('sqlite:');

it('is connection', function () use ($pdo)
{

  expect(new MySQL($pdo))
  ->toBeInstanceOf(Connection::class);

});

it('can get dsn', function ()
{

  expect(MySQL::dsn([
    'host' => 'localhost',
    'port' => 3306,
    'dbname' => 'database',
    'unix_socket' => '',
    'charset' => 'utf8mb4',
  ]))
  ->toEqual('mysql:host=localhost;port=3306;dbname=database;charset=utf8mb4');

});

it('can get dsn with unix socket', function ()
{

  expect(MySQL::dsn([
    'host' => 'localhost',
    'port' => 3306,
    'dbname' => 'database',
    'unix_socket' => '/tmp/mysql.sock',
    'charset' => 'utf8mb4',
  ]))
  ->toEqual('mysql:unix_socket=/tmp/mysql.sock;dbname=database;charset=utf8mb4');

});

it('can get alter statement', function () use ($pdo)
{

  $db = new MySQL($pdo);

  expect($db->alter())
  ->toBeInstanceOf(Alter::class);

  expect((string) $db->alter('test'))
  ->toEqual('ALTER TABLE test');

});

it('can get create statement', function () use ($pdo)
{

  $db = new MySQL($pdo);

  expect($db->create())
  ->toBeInstanceOf(Create::class);

  expect((string) $db->create('test'))
  ->toEqual('CREATE TABLE test');

});

it('can get create index statement', function () use ($pdo)
{

  $db = new MySQL($pdo);

  expect($db->createIndex('test'))
  ->toBeInstanceOf(CreateIndex::class);

  expect((string) $db->createIndex('test'))
  ->toEqual('CREATE INDEX test');

});

it('can get delete statement', function () use ($pdo)
{

  $db = new MySQL($pdo);

  expect($db->delete())
  ->toBeInstanceOf(Delete::class);

  expect((string) $db->delete('test'))
  ->toEqual('DELETE FROM test');

});

it('can get drop statement', function () use ($pdo)
{

  $db = new MySQL($pdo);

  expect($db->drop())
  ->toBeInstanceOf(Drop::class);

  expect((string) $db->drop('test'))
  ->toEqual('DROP TABLE test');

});

it('can get drop index statement', function () use ($pdo)
{

  $db = new MySQL($pdo);

  expect($db->dropIndex('test'))
  ->toBeInstanceOf(DropIndex::class);

  expect((string) $db->dropIndex('test'))
  ->toEqual('DROP INDEX test');

});

it('can get insert statement', function () use ($pdo)
{

  $db = new MySQL($pdo);

  expect($db->insert())
  ->toBeInstanceOf(Insert::class);

  expect((string) $db->insert('test'))
  ->toEqual('INSERT INTO test VALUES ()');

});

it('can get replace statement', function () use ($pdo)
{

  $db = new MySQL($pdo);

  expect($db->replace())
  ->toBeInstanceOf(Replace::class);

  expect((string) $db->replace('test'))
  ->toEqual('REPLACE INTO test VALUES ()');

});

it('can get select statement', function () use ($pdo)
{

  $db = new MySQL($pdo);

  expect($db->select())
  ->toBeInstanceOf(Select::class);

  expect((string) $db->select('test'))
  ->toEqual('SELECT * FROM test');

});

it('can get truncate statement', function () use ($pdo)
{

  $db = new MySQL($pdo);

  expect($db->truncate())
  ->toBeInstanceOf(Truncate::class);

  expect((string) $db->truncate('test'))
  ->toEqual('TRUNCATE TABLE test');

});

it('can get update statement', function () use ($pdo)
{

  $db = new MySQL($pdo);

  expect($db->update())
  ->toBeInstanceOf(Update::class);

  expect((string) $db->update('test'))
  ->toEqual('UPDATE test');

});