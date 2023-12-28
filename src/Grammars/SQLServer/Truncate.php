<?php

declare(strict_types=1);

namespace WTFramework\DBAL\Grammars\SQLServer;

use WTFramework\DBAL\Interfaces\Connection as InterfacesConnection;
use WTFramework\DBAL\Traits\Connection;
use WTFramework\SQL\Grammars\SQLServer\Statements\Truncate as StatementsTruncate;

class Truncate extends StatementsTruncate implements InterfacesConnection
{
  use Connection;
}