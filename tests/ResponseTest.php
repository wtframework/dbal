<?php

declare(strict_types=1);

use WTFramework\DBAL\Response;

$pdo = new PDO('sqlite:');

it('can execute statement', function () use ($pdo)
{

  createTestTable($pdo);

  $response = new Response($pdo->prepare('INSERT INTO test DEFAULT VALUES'));

  expect($response->execute())
  ->toBeInstanceOf(Response::class);

  expect($pdo->query('SELECT * FROM test')->fetchAll(PDO::FETCH_CLASS))
  ->toEqual([
    (object) ['id' => 1]
  ]);

});

it('can bind parameters', function () use ($pdo)
{

  createTestTable($pdo);

  $response = new Response($pdo->prepare('INSERT INTO test VALUES (?)'));

  $response->bind(1)->execute();

  expect($pdo->query('SELECT * FROM test')->fetchAll(PDO::FETCH_CLASS))
  ->toEqual([
    (object) ['id' => 1]
  ]);

});

it('can get result', function () use ($pdo)
{

  $response = new Response($pdo->query('SELECT 1 AS id'));

  expect($response->get())
  ->toEqual((object) [
    'id' => '1'
  ]);

});

it('can get array of results', function () use ($pdo)
{

  $response = new Response($pdo->query('SELECT 1 AS id UNION SELECT 2 AS id'));

  expect($response->all())
  ->toEqual([
    (object) ['id' => '1'],
    (object) ['id' => '2'],
  ]);

});