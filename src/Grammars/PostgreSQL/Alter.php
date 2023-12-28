<?php

declare(strict_types=1);

namespace WTFramework\DBAL\Grammars\PostgreSQL;

use WTFramework\DBAL\Interfaces\Connection as InterfacesConnection;
use WTFramework\DBAL\Traits\Connection;
use WTFramework\SQL\Grammars\PostgreSQL\Statements\Alter as StatementsAlter;

class Alter extends StatementsAlter implements InterfacesConnection
{
  use Connection;
}