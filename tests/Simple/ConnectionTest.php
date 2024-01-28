<?php

declare(strict_types=1);

use WTFramework\DBAL\Response;
use WTFramework\DBAL\Simple\Connection;
use WTFramework\DBAL\Simple\Statements\Delete;
use WTFramework\DBAL\Simple\Statements\Insert;
use WTFramework\DBAL\Simple\Statements\Replace;
use WTFramework\DBAL\Simple\Statements\Select;
use WTFramework\DBAL\Simple\Statements\Truncate;
use WTFramework\DBAL\Simple\Statements\Update;
use WTFramework\SQL\Services\Raw;
use WTFramework\SQL\Services\Subquery;
use WTFramework\SQL\Services\Table;
use WTFramework\SQL\Services\Upsert;

$connection = new Connection(new PDO('sqlite:'));

it('can connect', function ()
{

  expect(Connection::connect())
  ->toBeInstanceOf(Connection::class);

});

it('can execute an unprepared statement', function () use ($connection)
{

  expect($connection->unprepared('SELECT 1'))
  ->toBeInstanceOf(Response::class);

});

it('can prepare statement', function () use ($connection)
{

  expect($connection->prepare('SELECT ?', 1))
  ->toBeInstanceOf(Response::class);

});

it('can execute statement', function () use ($connection)
{

  expect($connection->execute('SELECT ?', 1))
  ->toBeInstanceOf(Response::class);

});

it('can get result', function () use ($connection)
{

  expect($connection->get('SELECT ? AS test', 1))
  ->toEqual((object) [
    'test' => '1'
  ]);

});

it('can get array of results', function () use ($connection)
{

  expect($connection->all('SELECT ? AS test UNION SELECT ? AS test', [1, 2]))
  ->toEqual([
    (object) ['test' => '1'],
    (object) ['test' => '2'],
  ]);

});

it('can delete', function () use ($connection)
{

  expect($connection->delete())
  ->toBeInstanceOf(Delete::class);

});

it('can insert', function () use ($connection)
{

  expect($connection->insert())
  ->toBeInstanceOf(Insert::class);

});

it('can replace', function () use ($connection)
{

  expect($connection->replace())
  ->toBeInstanceOf(Replace::class);

});

it('can select', function () use ($connection)
{

  expect($connection->select())
  ->toBeInstanceOf(Select::class);

});

it('can truncate', function () use ($connection)
{

  expect($connection->truncate())
  ->toBeInstanceOf(Truncate::class);

});

it('can update', function () use ($connection)
{

  expect($connection->update())
  ->toBeInstanceOf(Update::class);

});

it('can bind value', function() use ($connection)
{

  expect($raw = $connection->bind(1))
  ->toBeInstanceOf(Raw::class);

  expect((string) $raw)
  ->toBe('?');

  expect($raw->bindings())
  ->toBe([1]);

});

it('can get raw sql', function() use ($connection)
{

  expect($raw = $connection->raw('test'))
  ->toBeInstanceOf(Raw::class);

  expect((string) $raw)
  ->toBe('test');

});

it('can get raw sql with bindings', function() use ($connection)
{

  expect($connection->raw('?', 'test')->bindings())
  ->toBe(['test']);

  expect($connection->raw('?', 1)->bindings())
  ->toBe([1]);

  expect($connection->raw('? ?', ['test1', 'test2'])->bindings())
  ->toBe(['test1', 'test2']);

});

it('can get subquery', function() use ($connection)
{

  expect($subquery = $connection->subquery('SELECT'))
  ->toBeInstanceOf(Subquery::class);

  expect((string) $subquery)
  ->toBe('(SELECT)');

});

it('can get table', function() use ($connection)
{

  expect($table = $connection->table('t1'))
  ->toBeInstanceOf(Table::class);

  expect((string) $table)
  ->toBe('t1');

});

it('can get upsert', function() use ($connection)
{

  expect($upsert = $connection->upsert())
  ->toBeInstanceOf(Upsert::class);

  expect((string) $upsert)
  ->toBe('DO NOTHING');

});