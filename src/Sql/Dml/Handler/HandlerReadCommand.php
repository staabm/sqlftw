<?php
/**
 * This file is part of the SqlFtw library (https://github.com/sqlftw)
 *
 * Copyright (c) 2017 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace SqlFtw\Sql\Dml\Handler;

use SqlFtw\Sql\Expression\ExpressionNode;
use SqlFtw\Sql\Names\TableName;
use SqlFtw\SqlFormatter\SqlFormatter;

class HandlerReadCommand implements \SqlFtw\Sql\Command
{
    use \Dogma\StrictBehaviorMixin;

    /** @var \SqlFtw\Sql\Names\TableName */
    private $table;

    /** @var \SqlFtw\Sql\Dml\Handler\HandlerReadWhat */
    private $what;

    /** @var string|null */
    private $index;

    /** @var mixed[]|null */
    private $values;

    /** @var \SqlFtw\Sql\Expression\ExpressionNode|null */
    private $where;

    /** @var int|null */
    private $limit;

    /** @var int|null */
    private $offset;

    public function __construct(
        TableName $table,
        HandlerReadWhat $what,
        ?string $index = null,
        ?array $values = null,
        ?ExpressionNode $where = null,
        ?int $limit = null,
        ?int $offset = null
    ) {
        $this->table = $table;
        $this->what = $what;
        $this->index = $index;
        $this->values = $values;
        $this->where = $where;
        $this->limit = $limit;
        $this->offset = $offset;
    }

    public function getTable(): TableName
    {
        return $this->table;
    }

    public function getWhat(): HandlerReadWhat
    {
        return $this->what;
    }

    public function getIndex(): ?string
    {
        return $this->index;
    }

    /**
     * @return mixed[]|null
     */
    public function getValues(): ?array
    {
        return $this->values;
    }

    public function getWhere(): ?ExpressionNode
    {
        return $this->where;
    }

    public function getLimit(): ?int
    {
        return $this->limit;
    }

    public function getOffset(): ?int
    {
        return $this->offset;
    }

    public function serialize(SqlFormatter $formatter): string
    {
        $result = 'HANDLER ' . $this->table->serialize($formatter) . ' READ';
        if ($this->index !== null) {
            $result .= ' ' . $formatter->formatName($this->index);
        }
        $result .= ' ' . $this->what->serialize($formatter);

        if ($this->values !== null) {
            $result .= ' (' . $formatter->formatValuesList($this->values) . ')';
        }

        if ($this->where !== null) {
            $result .= ' WHERE ' . $this->where->serialize($formatter);
        }
        if ($this->limit !== null) {
            $result .= ' LIMIT ' . $this->limit;
        }
        if ($this->offset !== null) {
            $result .= ' OFFSET ' . $this->offset;
        }

        return $result;
    }

}