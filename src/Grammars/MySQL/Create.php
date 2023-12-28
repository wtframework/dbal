<?php

declare(strict_types=1);

namespace WTFramework\DBAL\Grammars\MySQL;

use WTFramework\DBAL\Interfaces\Connection as InterfacesConnection;
use WTFramework\DBAL\Traits\Connection;
use WTFramework\SQL\Grammars\MySQL\Statements\Create as StatementsCreate;

class Create extends StatementsCreate implements InterfacesConnection
{
  use Connection;
}