<?php

declare(strict_types=1);

use WTFramework\DBAL\DB;

function createTable(string $name): void
{

  DB::drop($name)->ifExists()();

  $table = DB::create($name);

  $table->integer('id')
  ->primaryKey()
  ->autoIncrement();

  $table();

}