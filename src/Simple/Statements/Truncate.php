<?php

declare(strict_types=1);

namespace WTFramework\DBAL\Simple\Statements;

use WTFramework\DBAL\Traits\StatementConnection;
use WTFramework\SQL\Simple\Statements\Truncate as StatementsTruncate;

class Truncate extends StatementsTruncate
{
  use StatementConnection;
}