<?php

declare(strict_types=1);

namespace WTFramework\DBAL\Statements;

use WTFramework\DBAL\Traits\StatementConnection;
use WTFramework\SQL\Statements\Update as StatementsUpdate;

class Update extends StatementsUpdate
{
  use StatementConnection;
}