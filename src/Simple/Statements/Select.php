<?php

declare(strict_types=1);

namespace WTFramework\DBAL\Simple\Statements;

use WTFramework\DBAL\Traits\StatementConnection;
use WTFramework\SQL\Simple\Statements\Select as StatementsSelect;

class Select extends StatementsSelect
{
  use StatementConnection;
}