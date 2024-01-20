<?php

declare(strict_types=1);

namespace WTFramework\DBAL\Statements;

use WTFramework\DBAL\Traits\StatementConnection;
use WTFramework\SQL\Statements\Drop as StatementsDrop;

class Drop extends StatementsDrop
{
  use StatementConnection;
}