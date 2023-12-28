<?php

declare(strict_types=1);

namespace WTFramework\DBAL\Grammars\MariaDB;

use WTFramework\DBAL\Interfaces\Connection as InterfacesConnection;
use WTFramework\DBAL\Traits\Connection;
use WTFramework\SQL\Grammars\MariaDB\Statements\Drop as StatementsDrop;

class Drop extends StatementsDrop implements InterfacesConnection
{
  use Connection;
}