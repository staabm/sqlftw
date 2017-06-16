<?php
/**
 * This file is part of the SqlFtw library (https://github.com/sqlftw)
 *
 * Copyright (c) 2017 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace SqlFtw\Sql\Ddl\Index;

use SqlFtw\Sql\Ddl\Table\Alter\AlterTableAlgorithm;
use SqlFtw\Sql\Ddl\Table\Alter\AlterTableLock;
use SqlFtw\Sql\Ddl\Table\Index\IndexDefinition;
use SqlFtw\SqlFormatter\SqlFormatter;

class CreateIndexCommand implements \SqlFtw\Sql\Command
{
    use \Dogma\StrictBehaviorMixin;

    /** @var \SqlFtw\Sql\Ddl\Table\Index\IndexDefinition */
    private $index;

    /** @var \SqlFtw\Sql\Ddl\Table\Alter\AlterTableAlgorithm|null */
    private $algorithm;

    /** @var \SqlFtw\Sql\Ddl\Table\Alter\AlterTableLock|null */
    private $lock;

    public function __construct(IndexDefinition $index, ?AlterTableAlgorithm $algorithm = null, ?AlterTableLock $lock = null)
    {
        $this->index = $index;
        $this->algorithm = $algorithm;
        $this->lock = $lock;
    }

    public function getIndex(): IndexDefinition
    {
        return $this->index;
    }

    public function getAlgorithm(): ?AlterTableAlgorithm
    {
        return $this->algorithm;
    }

    public function getLock(): ?AlterTableLock
    {
        return $this->lock;
    }

    public function serialize(SqlFormatter $formatter): string
    {
        $result = 'CREATE';
        // remove "ADD "
        $result .= substr($this->index->serialize($formatter), 4);

        if ($this->algorithm !== null) {
            $result .= ' ALGORITHM = ' . $this->algorithm->serialize($formatter);
        }
        if ($this->lock !== null) {
            $result .= ' LOCK = ' . $this->lock->serialize($formatter);
        }

        return $result;
    }

}