<?php

declare(strict_types=1);

namespace WTFramework\DBAL\Simple;

use WTFramework\DBAL\Interfaces\Connection as InterfacesConnection;
use WTFramework\DBAL\Traits\ConnectionConnection;
use WTFramework\DBAL\Simple\Statements\Delete;
use WTFramework\DBAL\Simple\Statements\Insert;
use WTFramework\DBAL\Simple\Statements\Replace;
use WTFramework\DBAL\Simple\Statements\Select;
use WTFramework\DBAL\Simple\Statements\Truncate;
use WTFramework\DBAL\Simple\Statements\Update;
use WTFramework\SQL\Interfaces\HasBindings;
use WTFramework\SQL\Services\Raw;
use WTFramework\SQL\Services\Subquery;
use WTFramework\SQL\Services\Table;
use WTFramework\SQL\Services\Upsert;

class Connection implements InterfacesConnection
{

  use ConnectionConnection;

  public function delete(): Delete
  {
    return (new Delete($this))->use($this->grammar);
  }

  public function insert(): Insert
  {
    return (new Insert($this))->use($this->grammar);
  }

  public function replace(): Replace
  {
    return (new Replace($this))->use($this->grammar);
  }

  public function select(): Select
  {
    return (new Select($this))->use($this->grammar);
  }

  public function truncate(): Truncate
  {
    return (new Truncate($this))->use($this->grammar);
  }

  public function update(): Update
  {
    return (new Update($this))->use($this->grammar);
  }

  public function bind(string|int $value): Raw
  {
    return $this->raw('?')->bind($value);
  }

  public function raw(
    string $string,
    string|int|array $bindings = []
  ): Raw
  {
    return new Raw($string, $bindings);
  }

  public function subquery(string|HasBindings $stmt): Subquery
  {
    return new Subquery($stmt);
  }

  public function table(string $name): Table
  {
    return new Table($name);
  }

  public function upsert(): Upsert
  {
    return new Upsert;
  }

}