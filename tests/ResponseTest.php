<?php

declare(strict_types=1);

use WTFramework\DBAL\Response;

$pdo = new PDO('sqlite:');

it('can get result', function () use ($pdo)
{

  $response = new Response(
    $pdo->prepare("SELECT ? AS test"), 1
  );

  expect($response->execute()->get())
  ->toEqual((object) [
    'test' => '1'
  ]);

});

it('can get array of results', function () use ($pdo)
{

  $response = new Response(
    $pdo->prepare("SELECT ? AS test UNION SELECT ? AS test"),  [1, 2]
  );

  expect($response->execute()->all())
  ->toEqual([
    (object) ['test' => '1'],
    (object) ['test' => '2'],
  ]);

});

it('can add macro', function () use ($pdo)
{

  Response::macro('test', function (bool $bool)
  {
    return $bool;
  });

  expect(Response::test(true))
  ->toBeTrue();

  $response = new Response(
    $pdo->prepare("SELECT ? AS test"), 1
  );

  expect($response->test(false))
  ->toBeFalse();

});