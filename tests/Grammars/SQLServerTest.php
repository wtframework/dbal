<?php

declare(strict_types=1);

use WTFramework\DBAL\Connections\SQLServer;
use WTFramework\DBAL\Grammars\SQLServer\Alter;
use WTFramework\DBAL\Grammars\SQLServer\Create;
use WTFramework\DBAL\Grammars\SQLServer\CreateIndex;
use WTFramework\DBAL\Grammars\SQLServer\Delete;
use WTFramework\DBAL\Grammars\SQLServer\Drop;
use WTFramework\DBAL\Grammars\SQLServer\DropIndex;
use WTFramework\DBAL\Grammars\SQLServer\Insert;
use WTFramework\DBAL\Grammars\SQLServer\Select;
use WTFramework\DBAL\Grammars\SQLServer\Truncate;
use WTFramework\DBAL\Grammars\SQLServer\Update;
use WTFramework\DBAL\Interfaces\Connection;
use WTFramework\SQL\Grammars\SQLServer\Helpers\Column;
use WTFramework\SQL\Grammars\SQLServer\Helpers\Constraint;
use WTFramework\SQL\Grammars\SQLServer\Helpers\CTE;
use WTFramework\SQL\Grammars\SQLServer\Helpers\Subquery;
use WTFramework\SQL\Grammars\SQLServer\Helpers\Table;
use WTFramework\SQL\Grammars\SQLServer\Statements\Alter as StatementsAlter;
use WTFramework\SQL\Grammars\SQLServer\Statements\Create as StatementsCreate;
use WTFramework\SQL\Grammars\SQLServer\Statements\CreateIndex as StatementsCreateIndex;
use WTFramework\SQL\Grammars\SQLServer\Statements\Delete as StatementsDelete;
use WTFramework\SQL\Grammars\SQLServer\Statements\Drop as StatementsDrop;
use WTFramework\SQL\Grammars\SQLServer\Statements\DropIndex as StatementsDropIndex;
use WTFramework\SQL\Grammars\SQLServer\Statements\Insert as StatementsInsert;
use WTFramework\SQL\Grammars\SQLServer\Statements\Select as StatementsSelect;
use WTFramework\SQL\Grammars\SQLServer\Statements\Truncate as StatementsTruncate;
use WTFramework\SQL\Grammars\SQLServer\Statements\Update as StatementsUpdate;

$connection = new SQLServer(new PDO('sqlite:'));

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

  $column = SQLServer::column('test');

  expect($column)
  ->toBeInstanceOf(Column::class);

  expect((string) $column)
  ->toBe('test');

});

it('can get constraint helper', function ()
{

  $constraint = SQLServer::constraint('test');

  expect($constraint)
  ->toBeInstanceOf(Constraint::class);

  expect((string) $constraint)
  ->toBe('CONSTRAINT test');

});

it('can get cte helper', function ()
{

  $cte = SQLServer::cte('test', 'SELECT');

  expect($cte)
  ->toBeInstanceOf(CTE::class);

  expect((string) $cte)
  ->toBe('test AS (SELECT)');

});

it('cannot get index helper', function ()
{
  SQLServer::index('test');
})
->throws(BadMethodCallException::class, 'SQLServer does not support indexes.');

it('cannot get partition helper', function ()
{
  SQLServer::partition('test');
})
->throws(BadMethodCallException::class, 'SQLServer does not support partitions.');

it('cannot get subpartition helper', function ()
{
  SQLServer::subpartition('test');
})
->throws(BadMethodCallException::class, 'SQLServer does not support subpartitions.');

it('can get subquery helper', function ()
{

  $subquery = SQLServer::subquery('SELECT');

  expect($subquery)
  ->toBeInstanceOf(Subquery::class);

  expect((string) $subquery)
  ->toBe('(SELECT)');

});

it('can get table helper', function ()
{

  $table = SQLServer::table('test');

  expect($table)
  ->toBeInstanceOf(Table::class);

  expect((string) $table)
  ->toBe('test');

});

it('cannot get upsert helper', function ()
{
  SQLServer::upsert();
})
->throws(BadMethodCallException::class, 'SQLServer does not support upserts.');