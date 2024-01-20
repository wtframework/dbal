<?php

declare(strict_types=1);

namespace WTFramework\DBAL\Simple\Statements;

use WTFramework\DBAL\Traits\StatementConnection;
use WTFramework\SQL\Simple\Statements\Delete as StatementsDelete;

class Delete extends StatementsDelete
{
  use StatementConnection;
}