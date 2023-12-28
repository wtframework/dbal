<?php

declare(strict_types=1);

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
use WTFramework\DBAL\Interfaces\Connection;
use WTFramework\SQL\Grammars\PostgreSQL\Helpers\Column;
use WTFramework\SQL\Grammars\PostgreSQL\Helpers\Constraint;
use WTFramework\SQL\Grammars\PostgreSQL\Helpers\CTE;
use WTFramework\SQL\Grammars\PostgreSQL\Helpers\Subquery;
use WTFramework\SQL\Grammars\PostgreSQL\Helpers\Table;
use WTFramework\SQL\Grammars\PostgreSQL\Helpers\Upsert;
use WTFramework\SQL\Grammars\PostgreSQL\Statements\Alter as StatementsAlter;
use WTFramework\SQL\Grammars\PostgreSQL\Statements\Create as StatementsCreate;
use WTFramework\SQL\Grammars\PostgreSQL\Statements\CreateIndex as StatementsCreateIndex;
use WTFramework\SQL\Grammars\PostgreSQL\Statements\Delete as StatementsDelete;
use WTFramework\SQL\Grammars\PostgreSQL\Statements\Drop as StatementsDrop;
use WTFramework\SQL\Grammars\PostgreSQL\Statements\DropIndex as StatementsDropIndex;
use WTFramework\SQL\Grammars\PostgreSQL\Statements\Insert as StatementsInsert;
use WTFramework\SQL\Grammars\PostgreSQL\Statements\Select as StatementsSelect;
use WTFramework\SQL\Grammars\PostgreSQL\Statements\Truncate as StatementsTruncate;
use WTFramework\SQL\Grammars\PostgreSQL\Statements\Update as StatementsUpdate;

$connection = new PostgreSQL(new PDO('sqlite:'));

it('extends sql alter', function () use ($connection)
{

  expect(new Alter($connection))
  ->toBeInstanceOf(StatementsAlter::class)
  ->toBeInstanceOf(Connection::class);

});

it('extends sql create', function () use ($connection)
{

  expect(new Create($connection))
  ->toBeInstanceOf(StatementsCreate::class)
  ->toBeInstanceOf(Connection::class);

});

it('extends sql create index', function () use ($connection)
{

  expect(new CreateIndex($connection, 'test'))
  ->toBeInstanceOf(StatementsCreateIndex::class)
  ->toBeInstanceOf(Connection::class);

});

it('extends sql delete', function () use ($connection)
{

  expect(new Delete($connection))
  ->toBeInstanceOf(StatementsDelete::class)
  ->toBeInstanceOf(Connection::class);

});

it('extends sql drop', function () use ($connection)
{

  expect(new Drop($connection))
  ->toBeInstanceOf(StatementsDrop::class)
  ->toBeInstanceOf(Connection::class);

});

it('extends sql drop index', function () use ($connection)
{

  expect(new DropIndex($connection, 'test'))
  ->toBeInstanceOf(StatementsDropIndex::class)
  ->toBeInstanceOf(Connection::class);

});

it('extends sql insert', function () use ($connection)
{

  expect(new Insert($connection))
  ->toBeInstanceOf(StatementsInsert::class)
  ->toBeInstanceOf(Connection::class);

});

it('extends sql select', function () use ($connection)
{

  expect(new Select($connection))
  ->toBeInstanceOf(StatementsSelect::class)
  ->toBeInstanceOf(Connection::class);

});

it('extends sql truncate', function () use ($connection)
{

  expect(new Truncate($connection))
  ->toBeInstanceOf(StatementsTruncate::class)
  ->toBeInstanceOf(Connection::class);

});

it('extends sql update', function () use ($connection)
{

  expect(new Update($connection))
  ->toBeInstanceOf(StatementsUpdate::class)
  ->toBeInstanceOf(Connection::class);

});

it('can get column helper', function ()
{

  $column = PostgreSQL::column('test');

  expect($column)
  ->toBeInstanceOf(Column::class);

  expect((string) $column)
  ->toBe('test');

});

it('can get constraint helper', function ()
{

  $constraint = PostgreSQL::constraint('test');

  expect($constraint)
  ->toBeInstanceOf(Constraint::class);

  expect((string) $constraint)
  ->toBe('CONSTRAINT test');

});

it('can get cte helper', function ()
{

  $cte = PostgreSQL::cte('test', 'SELECT');

  expect($cte)
  ->toBeInstanceOf(CTE::class);

  expect((string) $cte)
  ->toBe('test AS (SELECT)');

});

it('cannot get index helper', function ()
{
  PostgreSQL::index('test');
})
->throws(BadMethodCallException::class, 'PostgreSQL does not support indexes.');

it('cannot get partition helper', function ()
{
  PostgreSQL::partition('test');
})
->throws(BadMethodCallException::class, 'PostgreSQL does not support partitions.');

it('cannot get subpartition helper', function ()
{
  PostgreSQL::subpartition('test');
})
->throws(BadMethodCallException::class, 'PostgreSQL does not support subpartitions.');

it('can get subquery helper', function ()
{

  $subquery = PostgreSQL::subquery('SELECT');

  expect($subquery)
  ->toBeInstanceOf(Subquery::class);

  expect((string) $subquery)
  ->toBe('(SELECT)');

});

it('can get table helper', function ()
{

  $table = PostgreSQL::table('test');

  expect($table)
  ->toBeInstanceOf(Table::class);

  expect((string) $table)
  ->toBe('test');

});

it('can get upsert helper', function ()
{

  $upsert = PostgreSQL::upsert();

  expect($upsert)
  ->toBeInstanceOf(Upsert::class);

});