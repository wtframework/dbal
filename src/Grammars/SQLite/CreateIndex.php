<?php

declare(strict_types=1);

namespace WTFramework\DBAL\Grammars\SQLite;

use WTFramework\DBAL\Interfaces\Connection as InterfacesConnection;
use WTFramework\DBAL\Traits\Connection;
use WTFramework\SQL\Grammars\SQLite\Statements\CreateIndex as StatementsCreateIndex;

class CreateIndex extends StatementsCreateIndex implements InterfacesConnection
{
  use Connection;
}