<?php

declare(strict_types=1);

namespace WTFramework\DBAL\Statements;

use WTFramework\DBAL\Traits\StatementConnection;
use WTFramework\SQL\Statements\Select as StatementsSelect;

class Select extends StatementsSelect
{
  use StatementConnection;
}