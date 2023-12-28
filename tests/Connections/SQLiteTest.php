<?php

declare(strict_types=1);

use WTFramework\DBAL\Connection;
use WTFramework\DBAL\Connections\SQLite;
use WTFramework\DBAL\Grammars\SQLite\Alter;
use WTFramework\DBAL\Grammars\SQLite\Create;
use WTFramework\DBAL\Grammars\SQLite\CreateIndex;
use WTFramework\DBAL\Grammars\SQLite\Delete;
use WTFramework\DBAL\Grammars\SQLite\Drop;
use WTFramework\DBAL\Grammars\SQLite\DropIndex;
use WTFramework\DBAL\Grammars\SQLite\Insert;
use WTFramework\DBAL\Grammars\SQLite\Replace;
use WTFramework\DBAL\Grammars\SQLite\Select;
use WTFramework\DBAL\Grammars\SQLite\Update;

$pdo = new PDO('sqlite:');

it('is connection', function () use ($pdo)
{

  expect(new SQLite($pdo))
  ->toBeInstanceOf(Connection::class);

});

it('can get dsn', function ()
{

  expect(SQLite::dsn([
    'database' => ':memory:',
  ]))
  ->toEqual('sqlite::memory:');

});

it('can get alter statement', function () use ($pdo)
{

  $db = new SQLite($pdo);

  expect($db->alter())
  ->toBeInstanceOf(Alter::class);

  expect((string) $db->alter('test'))
  ->toEqual('ALTER TABLE test');

});

it('can get create statement', function () use ($pdo)
{

  $db = new SQLite($pdo);

  expect($db->create())
  ->toBeInstanceOf(Create::class);

  expect((string) $db->create('test'))
  ->toEqual('CREATE TABLE test');

});

it('can get create index statement', function () use ($pdo)
{

  $db = new SQLite($pdo);

  expect($db->createIndex('test'))
  ->toBeInstanceOf(CreateIndex::class);

  expect((string) $db->createIndex('test'))
  ->toEqual('CREATE INDEX test');

});

it('can get delete statement', function () use ($pdo)
{

  $db = new SQLite($pdo);

  expect($db->delete())
  ->toBeInstanceOf(Delete::class);

  expect((string) $db->delete('test'))
  ->toEqual('DELETE FROM test');

});

it('can get drop statement', function () use ($pdo)
{

  $db = new SQLite($pdo);

  expect($db->drop())
  ->toBeInstanceOf(Drop::class);

  expect((string) $db->drop('test'))
  ->toEqual('DROP TABLE test');

});

it('can get drop index statement', function () use ($pdo)
{

  $db = new SQLite($pdo);

  expect($db->dropIndex('test'))
  ->toBeInstanceOf(DropIndex::class);

  expect((string) $db->dropIndex('test'))
  ->toEqual('DROP INDEX test');

});

it('can get insert statement', function () use ($pdo)
{

  $db = new SQLite($pdo);

  expect($db->insert())
  ->toBeInstanceOf(Insert::class);

  expect((string) $db->insert('test'))
  ->toEqual('INSERT INTO test DEFAULT VALUES');

});

it('can get replace statement', function () use ($pdo)
{

  $db = new SQLite($pdo);

  expect($db->replace())
  ->toBeInstanceOf(Replace::class);

  expect((string) $db->replace('test'))
  ->toEqual('REPLACE INTO test DEFAULT VALUES');

});

it('can get select statement', function () use ($pdo)
{

  $db = new SQLite($pdo);

  expect($db->select())
  ->toBeInstanceOf(Select::class);

  expect((string) $db->select('test'))
  ->toEqual('SELECT * FROM test');

});

it('can get update statement', function () use ($pdo)
{

  $db = new SQLite($pdo);

  expect($db->update())
  ->toBeInstanceOf(Update::class);

  expect((string) $db->update('test'))
  ->toEqual('UPDATE test');

});