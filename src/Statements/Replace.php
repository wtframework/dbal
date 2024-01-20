<?php

declare(strict_types=1);

namespace WTFramework\DBAL\Statements;

use WTFramework\DBAL\Traits\StatementConnection;
use WTFramework\SQL\Statements\Replace as StatementsReplace;

class Replace extends StatementsReplace
{
  use StatementConnection;
}