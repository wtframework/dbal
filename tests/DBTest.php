<?php

declare(strict_types=1);

use WTFramework\Config\Config;
use WTFramework\DBAL\Connection;
use WTFramework\DBAL\DB;
use WTFramework\DBAL\Response;
use WTFramework\DBAL\Statements\Alter;
use WTFramework\DBAL\Statements\Create;
use WTFramework\DBAL\Statements\CreateIndex;
use WTFramework\DBAL\Statements\Delete;
use WTFramework\DBAL\Statements\Drop;
use WTFramework\DBAL\Statements\DropIndex;
use WTFramework\DBAL\Statements\Insert;
use WTFramework\DBAL\Statements\Replace;
use WTFramework\DBAL\Statements\Select;
use WTFramework\DBAL\Statements\Truncate;
use WTFramework\DBAL\Statements\Update;
use WTFramework\SQL\Services\Column;
use WTFramework\SQL\Services\Constraint;
use WTFramework\SQL\Services\CTE;
use WTFramework\SQL\Services\ForeignKey;
use WTFramework\SQL\Services\Index;
use WTFramework\SQL\Services\Outfile;
use WTFramework\SQL\Services\Partition;
use WTFramework\SQL\Services\Raw;
use WTFramework\SQL\Services\Subpartition;
use WTFramework\SQL\Services\Subquery;
use WTFramework\SQL\Services\Table;
use WTFramework\SQL\Services\Upsert;
use WTFramework\SQL\Services\Window;

beforeAll(function ()
{

  Config::set([
    'database' => [
      'default' => 'sqlite1',
      'connections' => [
        'sqlite1' => [],
        'sqlite2' => [],
        'sqlite3' => [
          'options' => [
            PDO::ATTR_CASE => PDO::CASE_LOWER,
          ]
        ]
      ]
    ]
  ]);

});

it('can connect', function ()
{

  expect(DB::connection())
  ->toBeInstanceOf(Connection::class);

});

it('can connect with options', function ()
{

  expect(DB::connection()->pdo->getAttribute(PDO::ATTR_CASE))
  ->toBe(PDO::CASE_NATURAL);

  expect(DB::connection('sqlite3')->pdo->getAttribute(PDO::ATTR_CASE))
  ->toBe(PDO::CASE_LOWER);

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

  createTable('test');

  expect(DB::affectedRows("INSERT INTO test VALUES (?), (?)"), [1, 2])
  ->toBe(2);

});

it('can perform transaction', function ()
{

  createTable('test');

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

  createTable('test');

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

it('can alter', function ()
{

  expect(DB::alter())
  ->toBeInstanceOf(Alter::class);

  expect((string) DB::alter('test'))
  ->toBe("ALTER TABLE test");

});

it('can create', function ()
{

  expect(DB::create())
  ->toBeInstanceOf(Create::class);

  expect((string) DB::create('test'))
  ->toBe("CREATE TABLE test");

});

it('can create index', function ()
{

  expect($stmt = DB::createIndex('i0'))
  ->toBeInstanceOf(CreateIndex::class);

  expect((string) $stmt)
  ->toBe("CREATE INDEX i0");

});

it('can delete', function ()
{

  expect(DB::delete())
  ->toBeInstanceOf(Delete::class);

  expect((string) DB::delete('test'))
  ->toBe("DELETE FROM test");

});

it('can drop', function ()
{

  expect(DB::drop())
  ->toBeInstanceOf(Drop::class);

  expect((string) DB::drop('test'))
  ->toBe("DROP TABLE test");

});

it('can drop index', function ()
{

  expect($stmt = DB::dropIndex('i0'))
  ->toBeInstanceOf(DropIndex::class);

  expect((string) $stmt)
  ->toBe("DROP INDEX i0");

});

it('can insert', function ()
{

  expect(DB::insert())
  ->toBeInstanceOf(Insert::class);

  expect((string) DB::insert('test'))
  ->toBe("INSERT INTO test DEFAULT VALUES");

});

it('can replace', function ()
{

  expect(DB::replace())
  ->toBeInstanceOf(Replace::class);

  expect((string) DB::replace('test'))
  ->toBe("REPLACE INTO test DEFAULT VALUES");

});

it('can select', function ()
{

  expect(DB::select())
  ->toBeInstanceOf(Select::class);

  expect((string) DB::select('test'))
  ->toBe("SELECT * FROM test");

});

it('can truncate', function ()
{

  expect(DB::truncate())
  ->toBeInstanceOf(Truncate::class);

  expect((string) DB::truncate('test'))
  ->toBe("TRUNCATE TABLE test");

});

it('can update', function ()
{

  expect(DB::update())
  ->toBeInstanceOf(Update::class);

  expect((string) DB::update('test'))
  ->toBe("UPDATE test");

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

it('can get column', function ()
{

  expect($column = DB::column('c1'))
  ->toBeInstanceOf(Column::class);

  expect((string) $column)
  ->toBe("c1");

});

it('can get constraint', function ()
{

  expect($constraint = DB::constraint('a'))
  ->toBeInstanceOf(Constraint::class);

  expect((string) $constraint)
  ->toBe("CONSTRAINT a");

});

it('can get cte', function ()
{

  expect($cte = DB::cte('cte', 'SELECT'))
  ->toBeInstanceOf(CTE::class);

  expect((string) $cte)
  ->toBe('cte AS (SELECT)');

});

it('can get foreign key', function ()
{

  expect($stmt = DB::foreignKey('c1'))
  ->toBeInstanceOf(ForeignKey::class);

  expect((string) $stmt)
  ->toBe("FOREIGN KEY (c1)");

});

it('can get index', function ()
{

  expect($index = DB::index('c1', 'i1'))
  ->toBeInstanceOf(Index::class);

  expect((string) $index)
  ->toBe("INDEX i1 (c1)");

});

it('can get outfile', function ()
{

  expect($outfile = DB::outfile('path'))
  ->toBeInstanceOf(Outfile::class);

  expect((string) $outfile)
  ->toBe("'path'");

});

it('can get partition', function ()
{

  expect($partition = DB::partition('p0'))
  ->toBeInstanceOf(Partition::class);

  expect((string) $partition)
  ->toBe('PARTITION p0');

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

it('can get subpartition', function ()
{

  expect($subpartition = DB::subpartition('p0'))
  ->toBeInstanceOf(Subpartition::class);

  expect((string) $subpartition)
  ->toBe('SUBPARTITION p0');

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

it('can get window', function ()
{

  expect($window = DB::window('w'))
  ->toBeInstanceOf(Window::class);

  expect((string) $window)
  ->toBe('w');

});

it('can add macro', function ()
{

  DB::macro('test', function (bool $bool)
  {
    return $bool;
  });

  expect(DB::test(true))
  ->toBeTrue();

});

it('can get logs', function ()
{

  DB::clearLogs();

  expect(DB::logs())
  ->toBe([]);

  DB::unprepared($sql1 = "SELECT 1");

  DB::prepare($sql2 = "SELECT ?", $bindings = [1]);

  expect(DB::logs())
  ->toBe([
    [$sql1],
    [$sql2, $bindings]
  ]);

});