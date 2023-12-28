<?php

declare(strict_types=1);

use WTFramework\DBAL\Connection;
use WTFramework\DBAL\Connections\PostgreSQL;
use WTFramework\DBAL\Grammars\PostgreSQL\Alter;
use WTFramework\DBAL\Grammars\PostgreSQL\Create;
use WTFramework\DBAL\Grammars\PostgreSQL\CreateIndex;
use WTFramework\DBAL\Grammars\PostgreSQL\Delete;
use WTFramework\DBAL\Grammars\PostgreSQL\Drop;
use WTFramework\DBAL\Grammars\PostgreSQL\DropIndex;
use WTFramework\DBAL\Grammars\PostgreSQL\Insert;
use WTFramework\DBAL\Grammars\PostgreSQL\Select;
use WTFramework\DBAL\Grammars\PostgreSQL\Truncate;
use WTFramework\DBAL\Grammars\PostgreSQL\Update;

$pdo = new PDO('sqlite:');

it('is connection', function () use ($pdo)
{

  expect(new PostgreSQL($pdo))
  ->toBeInstanceOf(Connection::class);

});

it('can get dsn', function ()
{

  expect(PostgreSQL::dsn([
    'host' => 'localhost',
    'port' => 3306,
    'dbname' => 'database',
    'sslmode' => 'prefer',
  ]))
  ->toEqual('pgsql:host=localhost;port=3306;dbname=database;sslmode=prefer');

});

it('can get alter statement', function () use ($pdo)
{

  $db = new PostgreSQL($pdo);

  expect($db->alter())
  ->toBeInstanceOf(Alter::class);

  expect((string) $db->alter('test'))
  ->toEqual('ALTER TABLE test');

});

it('can get create statement', function () use ($pdo)
{

  $db = new PostgreSQL($pdo);

  expect($db->create())
  ->toBeInstanceOf(Create::class);

  expect((string) $db->create('test'))
  ->toEqual('CREATE TABLE test');

});

it('can get create index statement', function () use ($pdo)
{

  $db = new PostgreSQL($pdo);

  expect($db->createIndex('test'))
  ->toBeInstanceOf(CreateIndex::class);

  expect((string) $db->createIndex('test'))
  ->toEqual('CREATE INDEX test');

});

it('can get delete statement', function () use ($pdo)
{

  $db = new PostgreSQL($pdo);

  expect($db->delete())
  ->toBeInstanceOf(Delete::class);

  expect((string) $db->delete('test'))
  ->toEqual('DELETE FROM test');

});

it('can get drop statement', function () use ($pdo)
{

  $db = new PostgreSQL($pdo);

  expect($db->drop())
  ->toBeInstanceOf(Drop::class);

  expect((string) $db->drop('test'))
  ->toEqual('DROP TABLE test');

});

it('can get drop index statement', function () use ($pdo)
{

  $db = new PostgreSQL($pdo);

  expect($db->dropIndex('test'))
  ->toBeInstanceOf(DropIndex::class);

  expect((string) $db->dropIndex('test'))
  ->toEqual('DROP INDEX test');

});

it('can get insert statement', function () use ($pdo)
{

  $db = new PostgreSQL($pdo);

  expect($db->insert())
  ->toBeInstanceOf(Insert::class);

  expect((string) $db->insert('test'))
  ->toEqual('INSERT INTO test DEFAULT VALUES');

});

it('can get select statement', function () use ($pdo)
{

  $db = new PostgreSQL($pdo);

  expect($db->select())
  ->toBeInstanceOf(Select::class);

  expect((string) $db->select('test'))
  ->toEqual('SELECT * FROM test');

});

it('can get truncate statement', function () use ($pdo)
{

  $db = new PostgreSQL($pdo);

  expect($db->truncate())
  ->toBeInstanceOf(Truncate::class);

  expect((string) $db->truncate('test'))
  ->toEqual('TRUNCATE TABLE test');

});

it('can get update statement', function () use ($pdo)
{

  $db = new PostgreSQL($pdo);

  expect($db->update())
  ->toBeInstanceOf(Update::class);

  expect((string) $db->update('test'))
  ->toEqual('UPDATE test');

});