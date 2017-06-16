<?php
/**
 * This file is part of the SqlFtw library (https://github.com/sqlftw)
 *
 * Copyright (c) 2017 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace SqlFtw\Sql\Dml\Transaction;

use Dogma\Check;
use SqlFtw\SqlFormatter\SqlFormatter;

class LockTablesCommand implements \SqlFtw\Sql\Command
{
    use \Dogma\StrictBehaviorMixin;

    /** @var \SqlFtw\Sql\Dml\Transaction\LockTablesItem[] */
    private $items;

    /**
     * @param \SqlFtw\Sql\Dml\Transaction\LockTablesItem[] $items
     */
    public function __construct(array $items)
    {
        Check::itemsOfType($items, LockTablesItem::class);

        $this->items = $items;
    }

    /**
     * @return \SqlFtw\Sql\Dml\Transaction\LockTablesItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function serialize(SqlFormatter $formatter): string
    {
        return 'LOCK TABLES ' . $formatter->formatSerializablesList($this->items);
    }

}