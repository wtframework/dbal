<?php

declare(strict_types=1);

use WTFramework\DBAL\Connections\MariaDB;
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
use WTFramework\DBAL\Interfaces\Connection;
use WTFramework\SQL\Grammars\MariaDB\Helpers\Column;
use WTFramework\SQL\Grammars\MariaDB\Helpers\Constraint;
use WTFramework\SQL\Grammars\MariaDB\Helpers\CTE;
use WTFramework\SQL\Grammars\MariaDB\Helpers\Index;
use WTFramework\SQL\Grammars\MariaDB\Helpers\Partition;
use WTFramework\SQL\Grammars\MariaDB\Helpers\Subpartition;
use WTFramework\SQL\Grammars\MariaDB\Helpers\Subquery;
use WTFramework\SQL\Grammars\MariaDB\Helpers\Table;
use WTFramework\SQL\Grammars\MariaDB\Statements\Alter as StatementsAlter;
use WTFramework\SQL\Grammars\MariaDB\Statements\Create as StatementsCreate;
use WTFramework\SQL\Grammars\MariaDB\Statements\CreateIndex as StatementsCreateIndex;
use WTFramework\SQL\Grammars\MariaDB\Statements\Delete as StatementsDelete;
use WTFramework\SQL\Grammars\MariaDB\Statements\Drop as StatementsDrop;
use WTFramework\SQL\Grammars\MariaDB\Statements\DropIndex as StatementsDropIndex;
use WTFramework\SQL\Grammars\MariaDB\Statements\Insert as StatementsInsert;
use WTFramework\SQL\Grammars\MariaDB\Statements\Replace as StatementsReplace;
use WTFramework\SQL\Grammars\MariaDB\Statements\Select as StatementsSelect;
use WTFramework\SQL\Grammars\MariaDB\Statements\Truncate as StatementsTruncate;
use WTFramework\SQL\Grammars\MariaDB\Statements\Update as StatementsUpdate;

$connection = new MariaDB(new PDO('sqlite:'));

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

  $column = MariaDB::column('test');

  expect($column)
  ->toBeInstanceOf(Column::class);

  expect((string) $column)
  ->toBe('test');

});

it('can get constraint helper', function ()
{

  $constraint = MariaDB::constraint('test');

  expect($constraint)
  ->toBeInstanceOf(Constraint::class);

  expect((string) $constraint)
  ->toBe('CONSTRAINT test');

});

it('can get cte helper', function ()
{

  $cte = MariaDB::cte('test', 'SELECT');

  expect($cte)
  ->toBeInstanceOf(CTE::class);

  expect((string) $cte)
  ->toBe('test AS (SELECT)');

});

it('cannot get index helper', function ()
{

  $index = MariaDB::index('test');

  expect($index)
  ->toBeInstanceOf(Index::class);

  expect((string) $index)
  ->toBe('INDEX test');

});

it('cannot get partition helper', function ()
{

  $partition = MariaDB::partition('test');

  expect($partition)
  ->toBeInstanceOf(Partition::class);

  expect((string) $partition)
  ->toBe('PARTITION test');

});

it('cannot get subpartition helper', function ()
{

  $subpartition = MariaDB::subpartition('test');

  expect($subpartition)
  ->toBeInstanceOf(Subpartition::class);

  expect((string) $subpartition)
  ->toBe('SUBPARTITION test');

});

it('can get subquery helper', function ()
{

  $subquery = MariaDB::subquery('SELECT');

  expect($subquery)
  ->toBeInstanceOf(Subquery::class);

  expect((string) $subquery)
  ->toBe('(SELECT)');

});

it('can get table helper', function ()
{

  $table = MariaDB::table('test');

  expect($table)
  ->toBeInstanceOf(Table::class);

  expect((string) $table)
  ->toBe('test');

});

it('cannot get upsert helper', function ()
{
  MariaDB::upsert();
})
->throws(BadMethodCallException::class, 'MariaDB does not support upserts.');