<?php

declare(strict_types=1);

use WTFramework\DBAL\DB;
use WTFramework\DBAL\Simple\DB as SimpleDB;

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

function simpleCreateTable(string $name): void
{

  SimpleDB::unprepared("DROP TABLE IF EXISTS $name");

  SimpleDB::unprepared("CREATE TABLE $name (id INTEGER PRIMARY KEY AUTOINCREMENT)");

}