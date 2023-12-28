<?php

declare(strict_types=1);

use WTFramework\DBAL\Connections\MariaDB;
use WTFramework\DBAL\Connections\SQLite;
use WTFramework\DBAL\Grammars\MariaDB\Alter;
use WTFramework\DBAL\Grammars\MariaDB\Create;
use WTFramework\DBAL\Grammars\MariaDB\CreateIndex;
use WTFramework\DBAL\Grammars\MariaDB\Delete;
use WTFramework\DBAL\Grammars\MariaDB\Drop;
use WTFramework\DBAL\Grammars\MariaDB\DropIndex;
use WTFramework\DBAL\Grammars\MariaDB\Insert;
use WTFramework\DBAL\Grammars\MariaDB\Replace;
use WTFramework\DBAL\Grammars\MariaDB\Select;
use WTFramework\DBAL\Grammars\MariaDB\Truncate;
use WTFramework\DBAL\Grammars\MariaDB\Update;
use WTFramework\DBAL\Response;

$pdo = new PDO('sqlite:');

it('can connect', function ()
{

  expect(SQLite::connect(['database' => ':memory:']))
  ->toBeInstanceOf(SQLite::class);

});

it('can query', function () use ($pdo)
{

  $connection = new SQLite($pdo);

  expect($connection->unprepared('SELECT 1'))
  ->toBeInstanceOf(Response::class);

});

it('can prepare statement', function () use ($pdo)
{

  $connection = new SQLite($pdo);

  expect($connection->prepare('SELECT ?', 1))
  ->toBeInstanceOf(Response::class);

});

it('can execute statement', function () use ($pdo)
{

  $connection = new SQLite($pdo);

  expect($connection->execute('SELECT ?', 1))
  ->toBeInstanceOf(Response::class);

});

it('can get result', function () use ($pdo)
{

  $connection = new SQLite($pdo);

  expect($connection->get('SELECT ? AS test', 1))
  ->toEqual((object) [
    'test' => '1'
  ]);

});

it('can get array of results', function () use ($pdo)
{

  $connection = new SQLite($pdo);

  expect($connection->all('SELECT ? AS test UNION SELECT ? AS test', [1, 2]))
  ->toEqual([
    (object) ['test' => '1'],
    (object) ['test' => '2'],
  ]);

});

it('can get last insert id', function () use ($pdo)
{

  createTestTable($pdo);

  $pdo->query('INSERT INTO test VALUES (2)');

  $connection = new SQLite($pdo);

  expect($connection->insertID())
  ->toEqual(2);

});

it('can commit transaction', function () use ($pdo)
{

  createTestTable($pdo);

  $connection = new SQLite($pdo);

  $connection->transaction(function ($connection) use ($pdo)
  {

    expect($connection)->toBeInstanceOf(SQLite::class);

    $pdo->query('INSERT INTO test DEFAULT VALUES');

  });

  expect($pdo->query('SELECT * FROM test')->fetchAll(PDO::FETCH_CLASS))
  ->toEqual([
    (object) ['id' => 1]
  ]);

});

it('can roll back transaction', function () use ($pdo)
{

  createTestTable($pdo);

  $connection = new SQLite($pdo);

  try
  {

    $connection->transaction(function () use ($pdo)
    {

      $pdo->query('INSERT INTO test DEFAULT VALUES');

      throw new Exception('Transaction rolled back');

    });

  }

  catch (Exception $e)
  {

    expect($pdo->query('SELECT * FROM test')->fetchAll(PDO::FETCH_CLASS))
    ->toEqual([]);

    throw $e;

  }

})
->throws(Exception::class, 'Transaction rolled back');

it('can alter', function () use ($pdo)
{

  $connection = new MariaDB($pdo);

  expect($connection->alter())
  ->toBeInstanceOf(Alter::class);

});

it('can create', function () use ($pdo)
{

  $connection = new MariaDB($pdo);

  expect($connection->create())
  ->toBeInstanceOf(Create::class);

});

it('can create index', function () use ($pdo)
{

  $connection = new MariaDB($pdo);

  expect($connection->createIndex('test'))
  ->toBeInstanceOf(CreateIndex::class);

});

it('can delete', function () use ($pdo)
{

  $connection = new MariaDB($pdo);

  expect($connection->delete())
  ->toBeInstanceOf(Delete::class);

});

it('can drop', function () use ($pdo)
{

  $connection = new MariaDB($pdo);

  expect($connection->drop())
  ->toBeInstanceOf(Drop::class);

});

it('can drop index', function () use ($pdo)
{

  $connection = new MariaDB($pdo);

  expect($connection->dropIndex('test'))
  ->toBeInstanceOf(DropIndex::class);

});

it('can insert', function () use ($pdo)
{

  $connection = new MariaDB($pdo);

  expect($connection->insert())
  ->toBeInstanceOf(Insert::class);

});

it('can replace', function () use ($pdo)
{

  $connection = new MariaDB($pdo);

  expect($connection->replace())
  ->toBeInstanceOf(Replace::class);

});

it('can select', function () use ($pdo)
{

  $connection = new MariaDB($pdo);

  expect($connection->select())
  ->toBeInstanceOf(Select::class);

});

it('can truncate', function () use ($pdo)
{

  $connection = new MariaDB($pdo);

  expect($connection->truncate())
  ->toBeInstanceOf(Truncate::class);

});

it('can update', function () use ($pdo)
{

  $connection = new MariaDB($pdo);

  expect($connection->update())
  ->toBeInstanceOf(Update::class);

});

it('can log statements', function () use ($pdo)
{

  createTestTable($pdo);

  $connection = new SQLite($pdo);

  $connection->clearStmts();

  $connection->unprepared('SELECT * FROM test');
  $connection->select('test')->prepare();
  $connection->select('test')->where('id', 'test')->execute();

  expect($connection->stmts())
  ->toEqual([
    (object) [
      'stmt' => "SELECT * FROM test",
      'bindings' => null,
    ],
    (object) [
      'stmt' => "SELECT * FROM test",
      'bindings' => [],
    ],
    (object) [
      'stmt' => "SELECT * FROM test WHERE id = ?",
      'bindings' => ['test'],
    ]
  ]);

});