<?php

declare(strict_types=1);

namespace WTFramework\DBAL\Grammars\PostgreSQL;

use WTFramework\DBAL\Interfaces\Connection as InterfacesConnection;
use WTFramework\DBAL\Traits\Connection;
use WTFramework\SQL\Grammars\PostgreSQL\Statements\Update as StatementsUpdate;

class Update extends StatementsUpdate implements InterfacesConnection
{
  use Connection;
}