<?php

declare(strict_types=1);

namespace WTFramework\DBAL;

use WTFramework\DBAL\Interfaces\Connection as InterfacesConnection;
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
use WTFramework\DBAL\Traits\ConnectionConnection;
use WTFramework\SQL\Interfaces\HasBindings;
use WTFramework\SQL\Services\Column;
use WTFramework\SQL\Services\Constraint;
use WTFramework\SQL\Services\CTE;
use WTFramework\SQL\Services\ForeignKey;
use WTFramework\SQL\Services\Index;
use WTFramework\SQL\Services\Outfile;
use WTFramework\SQL\Services\Partition;
use WTFramework\SQL\Services\Raw;
use WTFramework\SQL\Services\Subpartition;
use WTFramework\SQL\Services\Subquery;
use WTFramework\SQL\Services\Table;
use WTFramework\SQL\Services\Upsert;
use WTFramework\SQL\Services\Window;
use WTFramework\SQL\Traits\Macroable;

class Connection implements InterfacesConnection
{

  use ConnectionConnection;
  use Macroable;

  public function alter(string|HasBindings|null $table = null): Alter
  {
    return (new Alter($this, $table))->use($this->grammar);
  }

  public function create(string|HasBindings|null $table = null): Create
  {
    return (new Create($this, $table))->use($this->grammar);
  }

  public function createIndex(string $index): CreateIndex
  {
    return (new CreateIndex($this, $index))->use($this->grammar);
  }

  public function delete(string|HasBindings|array|null $table = null): Delete
  {
    return (new Delete($this, $table))->use($this->grammar);
  }

  public function drop(string|HasBindings|array|null $table = null): Drop
  {
    return (new Drop($this, $table))->use($this->grammar);
  }

  public function dropIndex(string|array $index): DropIndex
  {
    return (new DropIndex($this, $index))->use($this->grammar);
  }

  public function insert(string|HasBindings|array|null $table = null): Insert
  {
    return (new Insert($this, $table))->use($this->grammar);
  }

  public function replace(string|HasBindings|array|null $table = null): Replace
  {
    return (new Replace($this, $table))->use($this->grammar);
  }

  public function select(string|HasBindings|array|null $table = null): Select
  {
    return (new Select($this, $table))->use($this->grammar);
  }

  public function truncate(string|HasBindings|array|null $table = null): Truncate
  {
    return (new Truncate($this, $table))->use($this->grammar);
  }

  public function update(string|HasBindings|array|null $table = null): Update
  {
    return (new Update($this, $table))->use($this->grammar);
  }

  public function bind(string|int $value): Raw
  {
    return $this->raw('?')->bind($value);
  }

  public function column(string $name): Column
  {
    return (new Column($name))->use($this->grammar);
  }

  public function constraint(string $name = ''): Constraint
  {
    return new Constraint($name);
  }

  public function cte(
    string $name,
    string|HasBindings $stmt
  ): CTE
  {
    return new CTE($name, $stmt);
  }

  public function foreignKey(string|array $column): ForeignKey
  {
    return new ForeignKey($column);
  }

  public function index(
    string|array $column,
    string $name = ''
  ): Index
  {
    return new Index($column, $name);
  }

  public function outfile(string $path): Outfile
  {
    return new Outfile($path);
  }

  public function partition(string $name): Partition
  {
    return new Partition($name);
  }

  public function raw(
    string $string,
    string|int|array $bindings = []
  ): Raw
  {
    return new Raw($string, $bindings);
  }

  public function subpartition(string $name): Subpartition
  {
    return new Subpartition($name);
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

  public function window(string $name = ''): Window
  {
    return new Window($name);
  }

}