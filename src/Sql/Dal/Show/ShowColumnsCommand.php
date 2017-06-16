<?php
/**
 * This file is part of the SqlFtw library (https://github.com/sqlftw)
 *
 * Copyright (c) 2017 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace SqlFtw\Sql\Dal\Show;

use SqlFtw\Sql\Expression\ExpressionNode;
use SqlFtw\Sql\Names\TableName;
use SqlFtw\SqlFormatter\SqlFormatter;

class ShowColumnsCommand extends \SqlFtw\Sql\Dal\Show\ShowCommand
{

    /** @var \SqlFtw\Sql\Names\TableName */
    private $table;

    /** @var bool */
    private $full;

    /** @var string|null */
    private $like;

    /** @var \SqlFtw\Sql\Expression\ExpressionNode|null */
    private $where;

    public function __construct(TableName $table, bool $full = false, ?string $like = null, ?ExpressionNode $where = null)
    {
        $this->table = $table;
        $this->full = $full;
        $this->like = $like;
        $this->where = $where;
    }

    public function getTable(): TableName
    {
        return $this->table;
    }

    public function isFull(): bool
    {
        return $this->full;
    }

    public function getLike(): ?string
    {
        return $this->like;
    }

    public function getWhere(): ?ExpressionNode
    {
        return $this->where;
    }

    public function serialize(SqlFormatter $formatter): string
    {
        $result = 'SHOW';
        if ($this->full) {
            $result .= ' FULL';
        }
        $result .= ' COLUMNS FROM ' . $this->table->serialize($formatter);
        if ($this->like !== null) {
            $result .= ' LIKE ' . $formatter->formatString($this->like);
        } elseif ($this->where) {
            $result .= ' WHERE ' . $this->where->serialize($formatter);
        }

        return $result;
    }

}