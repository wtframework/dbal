<?php

declare(strict_types=1);

namespace WTFramework\DBAL\Grammars\MariaDB;

use WTFramework\DBAL\Interfaces\Connection as InterfacesConnection;
use WTFramework\DBAL\Traits\Connection;
use WTFramework\SQL\Grammars\MariaDB\Statements\DropIndex as StatementsDropIndex;

class DropIndex extends StatementsDropIndex implements InterfacesConnection
{
  use Connection;
}