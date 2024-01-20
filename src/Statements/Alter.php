<?php

declare(strict_types=1);

namespace WTFramework\DBAL\Statements;

use WTFramework\DBAL\Traits\StatementConnection;
use WTFramework\SQL\Statements\Alter as StatementsAlter;

class Alter extends StatementsAlter
{
  use StatementConnection;
}