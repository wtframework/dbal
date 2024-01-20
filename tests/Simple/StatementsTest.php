<?php

declare(strict_types=1);

use WTFramework\DBAL\Simple\Connection;
use WTFramework\DBAL\Simple\Statements\Delete;
use WTFramework\DBAL\Simple\Statements\Insert;
use WTFramework\DBAL\Simple\Statements\Replace;
use WTFramework\DBAL\Simple\Statements\Select;
use WTFramework\DBAL\Simple\Statements\Truncate;
use WTFramework\DBAL\Simple\Statements\Update;

$connection = new Connection(new PDO('sqlite:'));

it('can delete', function () use ($connection)
{

  expect((string) (new Delete($connection))->from('t1'))
  ->toBe("DELETE FROM t1");

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