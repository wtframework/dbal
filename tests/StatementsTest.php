<?php

declare(strict_types=1);

use WTFramework\DBAL\Connection;
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

$connection = new Connection(new PDO('sqlite:'));

it('can alter', function () use ($connection)
{

  expect((string) (new Alter($connection))->table('t1'))
  ->toBe("ALTER TABLE t1");

});

it('can create', function () use ($connection)
{

  expect((string) (new Create($connection))->table('t1'))
  ->toBe("CREATE TABLE t1");

});

it('can create index', function () use ($connection)
{

  expect((string) (new CreateIndex($connection, 'i0'))->on('t1'))
  ->toBe("CREATE INDEX i0 ON t1");

});

it('can delete', function () use ($connection)
{

  expect((string) (new Delete($connection))->from('t1'))
  ->toBe("DELETE FROM t1");

});

it('can drop', function () use ($connection)
{

  expect((string) (new Drop($connection))->table('t1'))
  ->toBe("DROP TABLE t1");

});

it('can drop index', function () use ($connection)
{

  expect((string) (new DropIndex($connection, 'i0'))->on('t1'))
  ->toBe("DROP INDEX i0 ON t1");

});

it('can insert', function () use ($connection)
{

  expect((string) (new Insert($connection))->into('t1'))
  ->toBe("INSERT INTO t1 VALUES ()");

});

it('can replace', function () use ($connection)
{

  expect((string) (new Replace($connection))->into('t1'))
  ->toBe("REPLACE INTO t1 VALUES ()");

});

it('can select', function () use ($connection)
{

  expect((string) (new Select($connection))->from('t1'))
  ->toBe("SELECT * FROM t1");

});

it('can truncate', function () use ($connection)
{

  expect((string) (new Truncate($connection))->table('t1'))
  ->toBe("TRUNCATE TABLE t1");

});

it('can update', function () use ($connection)
{

  expect((string) (new Update($connection))->table('t1'))
  ->toBe("UPDATE t1");

});