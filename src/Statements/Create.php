<?php

declare(strict_types=1);

namespace WTFramework\DBAL\Statements;

use WTFramework\DBAL\Traits\StatementConnection;
use WTFramework\SQL\Statements\Create as StatementsCreate;

class Create extends StatementsCreate
{
  use StatementConnection;
}