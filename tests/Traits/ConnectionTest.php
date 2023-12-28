<?php

declare(strict_types=1);

use WTFramework\DBAL\Connections\SQLite;
use WTFramework\DBAL\Grammars\SQLite\Select;
use WTFramework\DBAL\Response;
use WTFramework\SQL\SQL;

$connection = new SQLite(new PDO('sqlite:'));

it('can query', function () use ($connection)
{

  $stmt = new Select($connection);

  expect($stmt->column('1')->unprepared())
  ->toBeInstanceOf(Response::class);

});

it('can prepare statement', function () use ($connection)
{

  $stmt = new Select($connection);

  expect($stmt->column('1')->prepare())
  ->toBeInstanceOf(Response::class);

});

it('can execute statement', function () use ($connection)
{

  $stmt = new Select($connection);

  expect($stmt->column('1')->execute())
  ->toBeInstanceOf(Response::class);

});

it('can get result', function () use ($connection)
{

  $stmt = new Select($connection);

  expect($stmt->column(['test' => SQL::bind(1)])->get())
  ->toEqual((object) [
    'test' => '1'
  ]);

});

it('can get array of results', function () use ($connection)
{

  $stmt = new Select($connection);

  expect(
    $stmt->column(['test' => 1])
    ->union('SELECT 2 AS test')
    ->all()
  )
  ->toEqual([
    (object) ['test' => '1'],
    (object) ['test' => '2'],
  ]);

});

it('can invoke', function () use ($connection)
{

  $stmt = new Select($connection);

  expect($response = $stmt->column(['test' => 1])())
  ->toBeInstanceOf(Response::class);

  expect($response->get())
  ->toEqual((object) [
    'test' => '1'
  ]);

});