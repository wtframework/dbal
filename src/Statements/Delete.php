<?php

declare(strict_types=1);

namespace WTFramework\DBAL\Statements;

use WTFramework\DBAL\Traits\StatementConnection;
use WTFramework\SQL\Statements\Delete as StatementsDelete;

class Delete extends StatementsDelete
{
  use StatementConnection;
}