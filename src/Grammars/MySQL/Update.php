<?php

declare(strict_types=1);

namespace WTFramework\DBAL\Grammars\MySQL;

use WTFramework\DBAL\Interfaces\Connection as InterfacesConnection;
use WTFramework\DBAL\Traits\Connection;
use WTFramework\SQL\Grammars\MySQL\Statements\Update as StatementsUpdate;

class Update extends StatementsUpdate implements InterfacesConnection
{
  use Connection;
}