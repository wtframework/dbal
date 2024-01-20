<?php

declare(strict_types=1);

namespace WTFramework\DBAL\Statements;

use WTFramework\DBAL\Traits\StatementConnection;
use WTFramework\SQL\Statements\Truncate as StatementsTruncate;

class Truncate extends StatementsTruncate
{
  use StatementConnection;
}