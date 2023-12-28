<?php

declare(strict_types=1);

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
use WTFramework\DBAL\Interfaces\Connection;
use WTFramework\SQL\Grammars\SQLite\Helpers\Column;
use WTFramework\SQL\Grammars\SQLite\Helpers\Constraint;
use WTFramework\SQL\Grammars\SQLite\Helpers\CTE;
use WTFramework\SQL\Grammars\SQLite\Helpers\Table;
use WTFramework\SQL\Grammars\SQLite\Helpers\Upsert;
use WTFramework\SQL\Grammars\SQLite\Statements\Alter as StatementsAlter;
use WTFramework\SQL\Grammars\SQLite\Statements\Create as StatementsCreate;
use WTFramework\SQL\Grammars\SQLite\Statements\CreateIndex as StatementsCreateIndex;
use WTFramework\SQL\Grammars\SQLite\Statements\Delete as StatementsDelete;
use WTFramework\SQL\Grammars\SQLite\Statements\Drop as StatementsDrop;
use WTFramework\SQL\Grammars\SQLite\Statements\DropIndex as StatementsDropIndex;
use WTFramework\SQL\Grammars\SQLite\Statements\Insert as StatementsInsert;
use WTFramework\SQL\Grammars\SQLite\Statements\Replace as StatementsReplace;
use WTFramework\SQL\Grammars\SQLite\Statements\Select as StatementsSelect;
use WTFramework\SQL\Grammars\SQLite\Statements\Update as StatementsUpdate;
use WTFramework\SQL\Helpers\Subquery;

$connection = new SQLite(new PDO('sqlite:'));

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

it('extends sql replace', function () use ($connection)
{

  expect(new Replace($connection))
  ->toBeInstanceOf(StatementsReplace::class)
  ->toBeInstanceOf(Connection::class);

});

it('extends sql select', function () use ($connection)
{

  expect(new Select($connection))
  ->toBeInstanceOf(StatementsSelect::class)
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

  $column = SQLite::column('test');

  expect($column)
  ->toBeInstanceOf(Column::class);

  expect((string) $column)
  ->toBe('test');

});

it('can get constraint helper', function ()
{

  $constraint = SQLite::constraint('test');

  expect($constraint)
  ->toBeInstanceOf(Constraint::class);

  expect((string) $constraint)
  ->toBe('CONSTRAINT test');

});

it('can get cte helper', function ()
{

  $cte = SQLite::cte('test', 'SELECT');

  expect($cte)
  ->toBeInstanceOf(CTE::class);

  expect((string) $cte)
  ->toBe('test AS (SELECT)');

});

it('cannot get index helper', function ()
{
  SQLite::index('test');
})
->throws(BadMethodCallException::class, 'SQLite does not support indexes.');

it('cannot get partition helper', function ()
{
  SQLite::partition('test');
})
->throws(BadMethodCallException::class, 'SQLite does not support partitions.');

it('cannot get subpartition helper', function ()
{
  SQLite::subpartition('test');
})
->throws(BadMethodCallException::class, 'SQLite does not support subpartitions.');

it('can get subquery helper', function ()
{

  $subquery = SQLite::subquery('SELECT');

  expect($subquery)
  ->toBeInstanceOf(Subquery::class);

  expect((string) $subquery)
  ->toBe('(SELECT)');

});

it('can get table helper', function ()
{

  $table = SQLite::table('test');

  expect($table)
  ->toBeInstanceOf(Table::class);

  expect((string) $table)
  ->toBe('test');

});

it('can get upsert helper', function ()
{

  $upsert = SQLite::upsert();

  expect($upsert)
  ->toBeInstanceOf(Upsert::class);

});