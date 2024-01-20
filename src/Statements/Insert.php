<?php

declare(strict_types=1);

namespace WTFramework\DBAL\Statements;

use WTFramework\DBAL\Traits\StatementConnection;
use WTFramework\SQL\Statements\Insert as StatementsInsert;

class Insert extends StatementsInsert
{
  use StatementConnection;
}