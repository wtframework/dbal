<?php

declare(strict_types=1);

namespace WTFramework\DBAL\Statements;

use WTFramework\DBAL\Traits\StatementConnection;
use WTFramework\SQL\Statements\CreateIndex as StatementsCreateIndex;

class CreateIndex extends StatementsCreateIndex
{
  use StatementConnection;
}