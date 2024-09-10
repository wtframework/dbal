<?php

declare(strict_types=1);

use WTFramework\DBAL\Connection;
use WTFramework\DBAL\Drivers\SQLite;
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
use WTFramework\SQL\Services\Index;
use WTFramework\SQL\Services\Outfile;
use WTFramework\SQL\Services\Partition;
use WTFramework\SQL\Services\Raw;
use WTFramework\SQL\Services\Subpartition;
use WTFramework\SQL\Services\Subquery;
use WTFramework\SQL\Services\Table;
use WTFramework\SQL\Services\Upsert;
use WTFramework\SQL\Services\Window;

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

it('can alter', function () use ($connection)
{

  expect($connection->alter())
  ->toBeInstanceOf(Alter::class);

  expect((string) $connection->alter('test'))
  ->toBe("ALTER TABLE test");

});

it('can create', function () use ($connection)
{

  expect($connection->create())
  ->toBeInstanceOf(Create::class);

  expect((string) $connection->create('test'))
  ->toBe("CREATE TABLE test");

});

it('can create index', function () use ($connection)
{

  expect($stmt = $connection->createIndex('i0'))
  ->toBeInstanceOf(CreateIndex::class);

  expect((string) $stmt)
  ->toBe("CREATE INDEX i0");

});

it('can delete', function () use ($connection)
{

  expect($connection->delete())
  ->toBeInstanceOf(Delete::class);

});

it('can drop', function () use ($connection)
{

  expect($connection->drop())
  ->toBeInstanceOf(Drop::class);

  expect((string) $connection->drop('test'))
  ->toBe("DROP TABLE test");

});

it('can drop index', function () use ($connection)
{

  expect($stmt = $connection->dropIndex('i0'))
  ->toBeInstanceOf(DropIndex::class);

  expect((string) $stmt)
  ->toBe("DROP INDEX i0");

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

  expect((string) $connection->truncate('test'))
  ->toBe("TRUNCATE TABLE test");

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

it('can get column', function() use ($connection)
{

  expect($column = $connection->column('c1'))
  ->toBeInstanceOf(Column::class);

  expect((string) $column)
  ->toBe("c1");

});

it('can get constraint', function() use ($connection)
{

  expect($constraint = $connection->constraint('a'))
  ->toBeInstanceOf(Constraint::class);

  expect((string) $constraint)
  ->toBe("CONSTRAINT a");

});

it('can get cte', function() use ($connection)
{

  expect($cte = $connection->cte('cte', 'SELECT'))
  ->toBeInstanceOf(CTE::class);

  expect((string) $cte)
  ->toBe('cte AS (SELECT)');

});

it('can get index', function() use ($connection)
{

  expect($index = $connection->index('i0'))
  ->toBeInstanceOf(Index::class);

  expect((string) $index)
  ->toBe("INDEX i0");

});

it('can get outfile', function() use ($connection)
{

  expect($outfile = $connection->outfile('path'))
  ->toBeInstanceOf(Outfile::class);

  expect((string) $outfile)
  ->toBe("'path'");

});

it('can get partition', function() use ($connection)
{

  expect($partition = $connection->partition('p0'))
  ->toBeInstanceOf(Partition::class);

  expect((string) $partition)
  ->toBe('PARTITION p0');

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

it('can get subpartition', function() use ($connection)
{

  expect($subpartition = $connection->subpartition('p0'))
  ->toBeInstanceOf(Subpartition::class);

  expect((string) $subpartition)
  ->toBe('SUBPARTITION p0');

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

it('can get window', function() use ($connection)
{

  expect($window = $connection->window('w'))
  ->toBeInstanceOf(Window::class);

  expect((string) $window)
  ->toBe('w');

});

it('can add macro', function () use ($connection)
{

  Connection::macro('test', function (bool $bool)
  {
    return $bool;
  });

  expect(Connection::test(true))
  ->toBeTrue();

  expect($connection->test(false))
  ->toBeFalse();

});

it('can get logs', function () use ($connection)
{

  $connection->clearLogs();

  expect($connection->logs())
  ->toBe([]);

  $connection->unprepared($sql1 = "SELECT 1");

  $connection->prepare($sql2 = "SELECT ?", $bindings = [1]);

  expect($connection->logs())
  ->toBe([
    [$sql1],
    [$sql2, $bindings]
  ]);

});