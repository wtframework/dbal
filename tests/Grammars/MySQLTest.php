<?php

declare(strict_types=1);

use WTFramework\DBAL\Connections\MySQL;
use WTFramework\DBAL\Grammars\MySQL\Alter;
use WTFramework\DBAL\Grammars\MySQL\Create;
use WTFramework\DBAL\Grammars\MySQL\CreateIndex;
use WTFramework\DBAL\Grammars\MySQL\Delete;
use WTFramework\DBAL\Grammars\MySQL\Drop;
use WTFramework\DBAL\Grammars\MySQL\DropIndex;
use WTFramework\DBAL\Grammars\MySQL\Insert;
use WTFramework\DBAL\Grammars\MySQL\Replace;
use WTFramework\DBAL\Grammars\MySQL\Select;
use WTFramework\DBAL\Grammars\MySQL\Truncate;
use WTFramework\DBAL\Grammars\MySQL\Update;
use WTFramework\DBAL\Interfaces\Connection;
use WTFramework\SQL\Grammars\MySQL\Helpers\Column;
use WTFramework\SQL\Grammars\MySQL\Helpers\Constraint;
use WTFramework\SQL\Grammars\MySQL\Helpers\CTE;
use WTFramework\SQL\Grammars\MySQL\Helpers\Index;
use WTFramework\SQL\Grammars\MySQL\Helpers\Partition;
use WTFramework\SQL\Grammars\MySQL\Helpers\Subpartition;
use WTFramework\SQL\Grammars\MySQL\Helpers\Subquery;
use WTFramework\SQL\Grammars\MySQL\Helpers\Table;
use WTFramework\SQL\Grammars\MySQL\Statements\Alter as StatementsAlter;
use WTFramework\SQL\Grammars\MySQL\Statements\Create as StatementsCreate;
use WTFramework\SQL\Grammars\MySQL\Statements\CreateIndex as StatementsCreateIndex;
use WTFramework\SQL\Grammars\MySQL\Statements\Delete as StatementsDelete;
use WTFramework\SQL\Grammars\MySQL\Statements\Drop as StatementsDrop;
use WTFramework\SQL\Grammars\MySQL\Statements\DropIndex as StatementsDropIndex;
use WTFramework\SQL\Grammars\MySQL\Statements\Insert as StatementsInsert;
use WTFramework\SQL\Grammars\MySQL\Statements\Replace as StatementsReplace;
use WTFramework\SQL\Grammars\MySQL\Statements\Select as StatementsSelect;
use WTFramework\SQL\Grammars\MySQL\Statements\Truncate as StatementsTruncate;
use WTFramework\SQL\Grammars\MySQL\Statements\Update as StatementsUpdate;

$connection = new MySQL(new PDO('sqlite:'));

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

  $column = MySQL::column('test');

  expect($column)
  ->toBeInstanceOf(Column::class);

  expect((string) $column)
  ->toBe('test');

});

it('can get constraint helper', function ()
{

  $constraint = MySQL::constraint('test');

  expect($constraint)
  ->toBeInstanceOf(Constraint::class);

  expect((string) $constraint)
  ->toBe('CONSTRAINT test');

});

it('can get cte helper', function ()
{

  $cte = MySQL::cte('test', 'SELECT');

  expect($cte)
  ->toBeInstanceOf(CTE::class);

  expect((string) $cte)
  ->toBe('test AS (SELECT)');

});

it('cannot get index helper', function ()
{

  $index = MySQL::index('test');

  expect($index)
  ->toBeInstanceOf(Index::class);

  expect((string) $index)
  ->toBe('INDEX test');

});

it('cannot get partition helper', function ()
{

  $partition = MySQL::partition('test');

  expect($partition)
  ->toBeInstanceOf(Partition::class);

  expect((string) $partition)
  ->toBe('PARTITION test');

});

it('cannot get subpartition helper', function ()
{

  $subpartition = MySQL::subpartition('test');

  expect($subpartition)
  ->toBeInstanceOf(Subpartition::class);

  expect((string) $subpartition)
  ->toBe('SUBPARTITION test');

});

it('can get subquery helper', function ()
{

  $subquery = MySQL::subquery('SELECT');

  expect($subquery)
  ->toBeInstanceOf(Subquery::class);

  expect((string) $subquery)
  ->toBe('(SELECT)');

});

it('can get table helper', function ()
{

  $table = MySQL::table('test');

  expect($table)
  ->toBeInstanceOf(Table::class);

  expect((string) $table)
  ->toBe('test');

});

it('cannot get upsert helper', function ()
{
  MySQL::upsert();
})
->throws(BadMethodCallException::class, 'MySQL does not support upserts.');