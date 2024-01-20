<?php

declare(strict_types=1);

namespace WTFramework\DBAL\Statements;

use WTFramework\DBAL\Traits\StatementConnection;
use WTFramework\SQL\Statements\DropIndex as StatementsDropIndex;

class DropIndex extends StatementsDropIndex
{
  use StatementConnection;
}