<?php
/**
 * This file is part of the SqlFtw library (https://github.com/sqlftw)
 *
 * Copyright (c) 2017 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace SqlFtw\Sql\Dal\Table;

use Dogma\Check;
use SqlFtw\Sql\Names\TableName;
use SqlFtw\SqlFormatter\SqlFormatter;

class CheckTableCommand implements \SqlFtw\Sql\TablesCommand
{
    use \Dogma\StrictBehaviorMixin;

    /** @var \SqlFtw\Sql\Names\TableName[] */
    private $tables;

    /** @var \SqlFtw\Sql\Dal\Table\CheckTableOption|null */
    private $option;

    /**
     * @param \SqlFtw\Sql\Names\TableName[] $tables
     * @param \SqlFtw\Sql\Dal\Table\CheckTableOption|null $option
     */
    public function __construct(array $tables, ?CheckTableOption $option = null)
    {
        Check::array($tables, 1);
        Check::itemsOfType($tables, TableName::class);

        $this->tables = $tables;
        $this->option = $option;
    }

    /**
     * @return \SqlFtw\Sql\Names\TableName[]
     */
    public function getTables(): array
    {
        return $this->tables;
    }

    public function getOption(): ?CheckTableOption
    {
        return $this->option;
    }

    public function serialize(SqlFormatter $formatter): string
    {
        $result = 'CHECK TABLE ' . $formatter->formatSerializablesList($this->tables);

        if ($this->option) {
            $result .= ' ' . $this->option->serialize($formatter);
        }

        return $result;
    }

}