<?php

declare(strict_types=1);

use WTFramework\Config\Config;
use WTFramework\DBAL\Response;
use WTFramework\DBAL\Simple\Connection;
use WTFramework\DBAL\Simple\DB;
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
  ->toBeInstanceOf(Connection::class);

});

it('uses singleton', function ()
{

  expect(DB::connection())
  ->toBe(DB::connection());

});

it('can get named singleton', function ()
{

  expect(DB::connection('sqlite2'))
  ->toBeInstanceOf(Connection::class)
  ->toBe(DB::connection('sqlite2'))
  ->not->toBe(DB::connection());

});

it('can execute unprepared statement', function ()
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

it('can get row count', function ()
{

  simpleCreateTable('test');

  expect(DB::affectedRows("INSERT INTO test VALUES (?), (?)"), [1, 2])
  ->toBe(2);

});

it('can perform transaction', function ()
{

  simpleCreateTable('test');

  DB::transaction(function ()
  {
    DB::execute("INSERT INTO test VALUES (?), (?)", [1, 2]);
  });

  expect(DB::get("SELECT COUNT(*) AS counter FROM test"))
  ->toEqual((object) [
    'counter' => 2,
  ]);

});

it('can fail transaction', function ()
{

  simpleCreateTable('test');

  try
  {

    DB::transaction(function ()
    {

      DB::execute("INSERT INTO test VALUES (?), (?)", [1, 2]);

      throw new Exception('Transaction failed');

    });

  }

  catch (Exception $e)
  {

    expect(DB::get("SELECT COUNT(*) AS counter FROM test"))
    ->toEqual((object) [
      'counter' => 0,
    ]);

    throw $e;

  }

})
->throws(Exception::class, 'Transaction failed');

it('can delete', function ()
{

  expect(DB::delete())
  ->toBeInstanceOf(Delete::class);

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

it('can truncate', function ()
{

  expect(DB::truncate())
  ->toBeInstanceOf(Truncate::class);

});

it('can update', function ()
{

  expect(DB::update())
  ->toBeInstanceOf(Update::class);

});

it('can bind value', function ()
{

  expect($raw = DB::bind(1))
  ->toBeInstanceOf(Raw::class);

  expect((string) $raw)
  ->toBe('?');

  expect($raw->bindings())
  ->toBe([1]);

});

it('can get raw sql', function ()
{

  expect($raw = DB::raw('test'))
  ->toBeInstanceOf(Raw::class);

  expect((string) $raw)
  ->toBe('test');

});

it('can get raw sql with bindings', function()
{

  expect(DB::raw('?', 'test')->bindings())
  ->toBe(['test']);

  expect(DB::raw('?', 1)->bindings())
  ->toBe([1]);

  expect(DB::raw('? ?', ['test1', 'test2'])->bindings())
  ->toBe(['test1', 'test2']);

});

it('can get subquery', function ()
{

  expect($subquery = DB::subquery('SELECT'))
  ->toBeInstanceOf(Subquery::class);

  expect((string) $subquery)
  ->toBe('(SELECT)');

});

it('can get table', function ()
{

  expect($table = DB::table('t1'))
  ->toBeInstanceOf(Table::class);

  expect((string) $table)
  ->toBe('t1');

});

it('can get upsert', function ()
{

  expect($upsert = DB::upsert())
  ->toBeInstanceOf(Upsert::class);

  expect((string) $upsert)
  ->toBe('DO NOTHING');

});