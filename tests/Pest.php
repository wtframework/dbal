<?php

declare(strict_types=1);

use WTFramework\DBAL\DB;

function createTable(string $name): void
{

  DB::drop()
  ->table($name)
  ->ifExists()();

  DB::create()
  ->table($name)
  ->column(
    DB::column('id')
    ->integer()
    ->primaryKey()
    ->autoIncrement()
  )();

}