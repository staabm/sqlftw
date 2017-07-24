<?php
/**
 * This file is part of the SqlFtw library (https://github.com/sqlftw)
 *
 * Copyright (c) 2017 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace SqlFtw\Sql\Dml\TableReference;

use Dogma\Check;
use Dogma\Type;
use SqlFtw\Sql\Names\TableName;
use SqlFtw\SqlFormatter\SqlFormatter;

class TableReferenceTable implements \SqlFtw\Sql\Dml\TableReference\TableReferenceNode
{
    use \Dogma\StrictBehaviorMixin;

    /** @var \SqlFtw\Sql\Names\TableName */
    private $table;

    /** @var string|null */
    private $alias;

    /** @var string[]|null */
    private $partitions;

    /** @var \SqlFtw\Sql\Dml\TableReference\IndexHint[]|null */
    private $indexHints;

    /**
     * @param \SqlFtw\Sql\Names\TableName $table
     * @param string|null $alias
     * @param string[]|null $partitions
     * @param \SqlFtw\Sql\Dml\TableReference\IndexHint[]|null $indexHints
     */
    public function __construct(TableName $table, ?string $alias, ?array $partitions, ?array $indexHints)
    {
        if ($partitions !== null) {
            Check::itemsOfType($partitions, Type::STRING);
        }
        if ($indexHints !== null) {
            Check::itemsOfType($indexHints, IndexHint::class);
        }
        $this->table = $table;
        $this->alias = $alias;
        $this->partitions = $partitions;
        $this->indexHints = $indexHints;
    }

    public function getType(): TableReferenceNodeType
    {
        return TableReferenceNodeType::get(TableReferenceNodeType::TABLE);
    }

    public function getTable(): TableName
    {
        return $this->table;
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    /**
     * @return string[]|null
     */
    public function getPartitions(): ?array
    {
        return $this->partitions;
    }

    /**
     * @return \SqlFtw\Sql\Dml\TableReference\IndexHint[]|null
     */
    public function getIndexHints(): ?array
    {
        return $this->indexHints;
    }

    public function serialize(SqlFormatter $formatter): string
    {
        $result = $this->table->serialize($formatter);
        if ($this->partitions !== null) {
            $result .= ' PARTITION (' . $formatter->formatNamesList($this->partitions) . ')';
        }
        if ($this->alias !== null) {
            $result .= ' AS ' . $formatter->formatName($this->alias);
        }
        if ($this->indexHints !== null) {
            $result .= $formatter->formatSerializablesList($this->indexHints);
        }

        return $result;
    }

}