<?php

declare(strict_types=1);

use WTFramework\Config\Config;
use WTFramework\DBAL\Connections\SQLite;
use WTFramework\DBAL\DB;
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
use WTFramework\DBAL\Response;
use WTFramework\SQL\Grammars\SQLite\Helpers\Column;
use WTFramework\SQL\Grammars\SQLite\Helpers\Constraint;
use WTFramework\SQL\Grammars\SQLite\Helpers\CTE;
use WTFramework\SQL\Grammars\SQLite\Helpers\Table;
use WTFramework\SQL\Grammars\SQLite\Helpers\Upsert;
use WTFramework\SQL\Helpers\Subquery;

beforeAll(function ()
{

  Config::set([
    'database' => [
      'default' => 'sqlite1',
      'connections' => [
        'sqlite1' => [],
        'sqlite2' => [],
      ]
    ]
  ]);

});

it('can connect', function ()
{

  expect(DB::connection())
  ->toBeInstanceOf(SQLite::class);

});

it('uses singleton', function ()
{

  expect(DB::connection())
  ->toBe(DB::connection());

});

it('can get named singleton', function ()
{

  expect(DB::connection('sqlite2'))
  ->toBeInstanceOf(SQLite::class)
  ->not()->toBe(DB::connection())
  ->toBe(DB::connection('sqlite2'));

});

it('can query', function ()
{

  expect(DB::unprepared('SELECT 1'))
  ->toBeInstanceOf(Response::class);

});

it('can prepare statement', function ()
{

  expect(DB::prepare('SELECT ?', 1))
  ->toBeInstanceOf(Response::class);

});

it('can execute statement', function ()
{

  expect(DB::execute('SELECT ?', 1))
  ->toBeInstanceOf(Response::class);

});

it('can get result', function ()
{

  expect(DB::get('SELECT ? AS test', 1))
  ->toEqual((object) [
    'test' => '1'
  ]);

});

it('can get array of results', function ()
{

  expect(DB::all('SELECT ? AS test UNION SELECT ? AS test', [1, 2]))
  ->toEqual([
    (object) ['test' => '1'],
    (object) ['test' => '2'],
  ]);

});

it('can get last insert id', function ()
{

  $pdo = DB::connection()->pdo;

  createTestTable($pdo);

  $pdo->query('INSERT INTO test VALUES (2)');

  expect(DB::insertID())
  ->toEqual(2);

});

it('can commit transaction', function ()
{

  $pdo = DB::connection()->pdo;

  createTestTable($pdo);

  DB::transaction(function ($connection) use ($pdo)
  {

    expect($connection)->toBeInstanceOf(SQLite::class);

    $pdo->query('INSERT INTO test DEFAULT VALUES');

  });

  expect($pdo->query('SELECT * FROM test')->fetchAll(PDO::FETCH_CLASS))
  ->toEqual([
    (object) ['id' => 1]
  ]);

});

it('can roll back transaction', function ()
{

  $pdo = DB::connection()->pdo;

  createTestTable($pdo);

  try
  {

    DB::transaction(function () use ($pdo)
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

it('can alter', function ()
{

  expect(DB::alter())
  ->toBeInstanceOf(Alter::class);

});

it('can create', function ()
{

  expect(DB::create())
  ->toBeInstanceOf(Create::class);

});

it('can create index', function ()
{

  expect(DB::createIndex('test'))
  ->toBeInstanceOf(CreateIndex::class);

});

it('can delete', function ()
{

  expect(DB::delete())
  ->toBeInstanceOf(Delete::class);

});

it('can drop', function ()
{

  expect(DB::drop())
  ->toBeInstanceOf(Drop::class);

});

it('can drop index', function ()
{

  expect(DB::dropIndex('test'))
  ->toBeInstanceOf(DropIndex::class);

});

it('can insert', function ()
{

  expect(DB::insert())
  ->toBeInstanceOf(Insert::class);

});

it('can replace', function ()
{

  expect(DB::replace())
  ->toBeInstanceOf(Replace::class);

});

it('can select', function ()
{

  expect(DB::select())
  ->toBeInstanceOf(Select::class);

});

it('cannot truncate', function ()
{
  DB::truncate();
})
->throws(BadMethodCallException::class, 'SQLite does not support TRUNCATE statements.');

it('can update', function ()
{

  expect(DB::update())
  ->toBeInstanceOf(Update::class);

});

it('can get column helper', function ()
{

  $column = DB::column('test');

  expect($column)
  ->toBeInstanceOf(Column::class);

  expect((string) $column)
  ->toBe('test');

});

it('can get constraint helper', function ()
{

  $constraint = DB::constraint('test');

  expect($constraint)
  ->toBeInstanceOf(Constraint::class);

  expect((string) $constraint)
  ->toBe('CONSTRAINT test');

});

it('can get cte helper', function ()
{

  $cte = DB::cte('test', 'SELECT');

  expect($cte)
  ->toBeInstanceOf(CTE::class);

  expect((string) $cte)
  ->toBe('test AS (SELECT)');

});

it('cannot get index helper', function ()
{
  DB::index('test');
})
->throws(BadMethodCallException::class, 'SQLite does not support indexes.');

it('cannot get partition helper', function ()
{
  DB::partition('test');
})
->throws(BadMethodCallException::class, 'SQLite does not support partitions.');

it('cannot get subpartition helper', function ()
{
  DB::subpartition('test');
})
->throws(BadMethodCallException::class, 'SQLite does not support subpartitions.');

it('can get subquery helper', function ()
{

  $subquery = DB::subquery('SELECT');

  expect($subquery)
  ->toBeInstanceOf(Subquery::class);

  expect((string) $subquery)
  ->toBe('(SELECT)');

});

it('can get table helper', function ()
{

  $table = DB::table('test');

  expect($table)
  ->toBeInstanceOf(Table::class);

  expect((string) $table)
  ->toBe('test');

});

it('can get upsert helper', function ()
{

  $upsert = DB::upsert();

  expect($upsert)
  ->toBeInstanceOf(Upsert::class);

});

it('can log statements', function ()
{

  $pdo = DB::connection()->pdo;

  createTestTable($pdo);

  DB::clearStmts();

  DB::unprepared('SELECT * FROM test');
  DB::select('test')->prepare();
  DB::select('test')->where('id', 'test')->execute();

  expect(DB::stmts())
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