<?php

declare(strict_types=1);

namespace WTFramework\DBAL\Grammars\SQLite;

use WTFramework\DBAL\Interfaces\Connection as InterfacesConnection;
use WTFramework\DBAL\Traits\Connection;
use WTFramework\SQL\Grammars\SQLite\Statements\Replace as StatementsReplace;

class Replace extends StatementsReplace implements InterfacesConnection
{
  use Connection;
}